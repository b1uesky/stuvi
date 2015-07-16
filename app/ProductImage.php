<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use File;
use Config;
use Aws\Laravel\AwsFacade;
use Intervention\Image\Facades\Image;

class ProductImage extends Model {

    /**
     * Get the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function product()
	{
		return $this->belongsTo('App\Product');
	}

    /**
     * Check if it is a test image.
     *
     * @return bool
     */
    public function isTestImage()
    {
        return substr($this->small_image, 0, 4) == 'http';
    }

    /**
     * Generate a filename for a product image, add size if necessary
     *
     * @param null $size
     * @param $file
     * @return string
     */
    public function generateFilename($size=null, $file)
    {
        $title = implode('-', explode(' ', $this->product->book->title));

        if ($size)
        {
            $filename = $title . '-' . $this->id . '-' . $size . '.' . $file->getClientOriginalExtension();
        }
        else
        {
            $filename = $title . '-' . $this->id . '.' . $file->getClientOriginalExtension();
        }

        return $filename;
    }

    /**
     * Resize the image to small, medium and large images.
     *
     * @param $image
     */
    public function resize($image)
    {
        $temp_path = Config::get('image.temp_path');
        $small_img_width = Config::get('image.resize.small.width');
        $small_img_height = Config::get('image.resize.small.height');
        $medium_img_height = Config::get('image.resize.medium.height');
        $large_img_height = Config::get('image.resize.large.height');

        // small
        Image::make($image)
            ->resize($small_img_width, $small_img_height)
            ->save($temp_path . $this->small_image);

        // medium
        Image::make($image)->resize(null, $medium_img_height, function ($constraint)
        {
            $constraint->aspectRatio();
        })->save($temp_path . $this->medium_image);

        // large
        $large_img = Image::make($image);

        if ($large_img->height() > $large_img_height)
        {
            $large_img->resize(null, $large_img_height, function ($constraint)
            {
                $constraint->aspectRatio();
            });
        }

        $large_img->save($temp_path . $this->large_image);
    }

    /**
     * Upload small, medium and large images to AWS S3.
     *
     */
    public function uploadToAWS()
    {
        $temp_path = Config::get('image.temp_path');

        // upload images to amazon s3
        foreach([$this->small_image, $this->medium_image, $this->large_image] as $key)
        {
            $s3 = AwsFacade::createClient('s3');

            $s3->putObject(array(
                'Bucket'        => Config::get('aws.buckets.product_image'),
                'Key'           => $key,
                'SourceFile'    => $temp_path . $key,
                'ACL'           => 'public-read'
            ));

            File::delete($temp_path . $key);
        }
    }
}

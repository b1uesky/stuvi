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
     * Get an image path with specific size.
     *
     * @param $size
     * @return mixed|string
     */
    public function getImagePath($size)
    {
        switch ($size)
        {
            case 'large':
                $image_path = $this->large_image;
                break;
            case 'medium':
                $image_path = $this->medium_image;
                break;
            case 'small':
                $image_path = $this->small_image;
                break;
            default:
                $image_path = $this->medium_image;
        }


        if ($this->isTestImage())
        {
            return $image_path;
        }
        else
        {
            return config('aws.url.stuvi-product-img') . $image_path;
        }
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

        $extension = $file->getClientOriginalExtension();

        if ($size)
        {
            $filename = $title . '-' . $this->id . '-' . $size . '.' . $extension;
        }
        else
        {
            $filename = $title . '-' . $this->id . '.' . $extension;
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

        $small_img_height = Config::get('image.resize.small.height');
        $medium_img_height = Config::get('image.resize.medium.height');
        $large_img_height = Config::get('image.resize.large.height');

        // small
        Image::make($image)->orientate()->resize(null, $small_img_height, function ($constraint)
        {
            $constraint->aspectRatio();
        })->save($temp_path . $this->small_image);

        // medium
        Image::make($image)->orientate()->resize(null, $medium_img_height, function ($constraint)
        {
            $constraint->aspectRatio();
        })->save($temp_path . $this->medium_image);

        // large
        $large_img = Image::make($image)->orientate();

        // only resize if the original image height is greater than the height we specified
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

    /**
     * Delete product image from AWS.
     */
    public function deleteFromAWS()
    {
        foreach([$this->small_image, $this->medium_image, $this->large_image] as $key)
        {
            $s3 = AwsFacade::createClient('s3');

            $s3->deleteObject(array(
                'Bucket'        => Config::get('aws.buckets.product_image'),
                'Key'           => $key,
            ));

        }
    }
}

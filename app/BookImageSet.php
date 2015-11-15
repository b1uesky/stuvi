<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use File;
use Aws\Laravel\AwsFacade;
use Intervention\Image\Facades\Image;

class BookImageSet extends Model
{

    protected $table = 'book_image_sets';
    protected $guarded = [];

    /**
     * Get the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo('App\Book');
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

        if ($image_path)
        {
            $bucket = app()->environment('production') ? config('aws.url.stuvi-book-img') : config('aws.url.stuvi-test-book-img');
            return $bucket . $image_path;
        }
        else
        {
            return config('book.default_image_path.' . $size);
        }
    }

    /**
     * Generate a filename for a book image, add size if necessary
     *
     * @param null $size
     * @param $file
     * @return string
     */
    public function generateFilename($size=null, $file)
    {
        $title = implode('-', explode(' ', $this->book->title));

        if ($file->extension)
        {
            // image created by Intervension
            $extension = $file->extension;
        }
        else
        {
            $extension = $file->getClientOriginalExtension();
        }

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
        $temp_path = config('image.temp_path');
        $small_img_width = config('image.resize.small.width');
        $small_img_height = config('image.resize.small.height');
        $medium_img_height = config('image.resize.medium.height');
        $large_img_height = config('image.resize.large.height');

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
        $temp_path = config('image.temp_path');
        $s3 = AwsFacade::createClient('s3');
        $bucket = app()->environment('production') ? config('aws.buckets.book_image') : config('aws.buckets.test_book_image');

        // upload images to amazon s3
        foreach([$this->small_image, $this->medium_image, $this->large_image] as $key)
        {
            $s3->putObject(array(
                'Bucket'        => $bucket,
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
        $s3 = AwsFacade::createClient('s3');
        $bucket = app()->environment('production') ? config('aws.buckets.book_image') : config('aws.buckets.test_book_image');

        foreach([$this->small_image, $this->medium_image, $this->large_image] as $key)
        {
            $s3->deleteObject(array(
                'Bucket'        => $bucket,
                'Key'           => $key,
            ));

        }
    }

}

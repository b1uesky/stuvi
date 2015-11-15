<?php namespace App\Helpers;

use App\BookImageSet;
use App\ProductImage;

class FileUploader {

    function __construct($file, $title, $folder, $id)
    {
        $this->file = $file;
        $this->title = $title;
        $this->folder = $folder;
        $this->id = $id;
        $this->destination = public_path() . $folder;
    }

    // The filename will be {TITLE}-{IMAGE_ID}.{EXTENSION}
    // e.g., Algorithms-1.jpg
    function setFilename($image_id)
    {
        $this->filename = $this->title . '-' . $image_id . '.' . $this->file->getClientOriginalExtension();
    }

    function setPath()
    {
        $this->path = $this->folder . $this->filename;
    }

    function getPath()
    {
        return $this->path;
    }

    function saveFile()
    {
        $this->file->move($this->destination, $this->path);
    }

    function saveBookImageSet()
    {
        $image_set = new BookImageSet();
        $image_set->book_id = $this->id;
        $image_set->save();

        $this->setFilename($image_set->id);
        $this->setPath();
        $this->saveFile();

        $image_set->large_image = $this->path;
        $image_set->save();
    }

    function saveProductImage()
    {
        $product_image = new ProductImage();
        $product_image->product_id = $this->id;
        $product_image->save();

        $this->setFilename($product_image->id);
        $this->setPath();
        $this->saveFile();

        $product_image->path = $this->path;
        $product_image->save();
    }

    public static function generateFilename($size=null, $file, $_title)
    {
        $title = implode('-', explode(' ', $_title));

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
            $filename = $title . '-' . uniqid() . '-' . $size . '.' . $extension;
        }
        else
        {
            $filename = $title . '-' . uniqid() . '.' . $extension;
        }

        return $filename;
    }
}

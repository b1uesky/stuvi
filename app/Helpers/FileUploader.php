<?php namespace App\Helpers;

class FileUploader {

    function __construct($file, $title, $folder)
    {
        $this->file = $file;
        $this->title = $title;
        $this->folder = $folder;
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
}

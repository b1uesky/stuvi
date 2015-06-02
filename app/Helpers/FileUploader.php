<?php namespace App\Helpers;

class FileUploader {

    function __construct($file, $title, $folder)
    {
        $this->file = $file;
        $this->title = $title;
        $this->destination = storage_path() . $folder;
        $this->filename = $this->generateFileName();
        $this->path = $this->generatePath();
    }

    function generateFileName()
    {
        return $this->title . '_' . $this->file->getClientOriginalName();
    }

    function generatePath()
    {
        // TODO: image storage
        // retrieve the path to an uploaded image
        // may be store relative path?
        return storage_path() . $this->destination . $this->filename;
    }

    function saveFile()
    {
        $this->file->move($this->destination, $this->filename);
    }
}

<?php namespace App\Helpers;

class FileUploader {

    function __construct($file, $title, $folder)
    {
        $this->file = $file;
        $this->title = $title;
        $this->folder = $folder;
        $this->destination = public_path() . $folder;
        $this->filename = $this->generateFileName();
        $this->path = $this->generatePath();
    }

    function generateFileName()
    {
        return $this->title . '_' . $this->file->getClientOriginalName();
    }

    function generatePath()
    {
        return $this->folder . $this->filename;
    }

    function saveFile()
    {
        $this->file->move($this->destination, $this->filename);
    }
}

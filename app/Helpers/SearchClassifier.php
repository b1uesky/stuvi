<?php namespace App\Helpers;

use Isbn\Isbn;

class SearchClassifier
{
    private $string;
    private $isIsbn;

    function __construct($string)
    {
        $this->string = $string;
        $this->isIsbn = false;
        $this->classify();
    }

    function classify()
    {
        $isbn = new Isbn();

        // check if the isbn is valid
        if ($isbn->validation->isbn($this->string))
        {
            $this->isIsbn = true;
        }
    }

    function isIsbn()
    {
        return $this->isIsbn;
    }
}

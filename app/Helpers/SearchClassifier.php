<?php namespace App\Helpers;

class SearchClassifier
{
    private $string;

    private $isIsbn;
    private $isTitle;
    private $isAuthor;

    function __construct($string)
    {
        $this->string = $string;
        $this->isIsbn = false;
        $this->isTitle = false;
        $this->isAuthor = false;
        $this->classify();
    }

    function classify()
    {
    }
}

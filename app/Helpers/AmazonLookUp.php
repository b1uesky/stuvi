<?php namespace App\Helpers;

use Config;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\ApaiIO;

class AmazonLookUp
{
    const DEFAULT_EDITION = 1;

    public function __construct($item_id, $id_type)
    {
        $this->item_id = $item_id;
        $this->id_type = $id_type;
        $this->config();
        $this->lookUp();
    }

    public function config()
    {
        $this->conf = new GenericConfiguration();

        try {
            $this->conf
                ->setCountry('com')
                ->setAccessKey(Config::get('services.amazon.access_key_id'))
                ->setSecretKey(Config::get('services.amazon.secret_access_key'))
                ->setAssociateTag(Config::get('services.amazon.associate_id'));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function lookUp()
    {
        $apaiIO = new ApaiIO($this->conf);

        $lookup = new Lookup();
        $lookup->setItemId($this->item_id);
        $lookup->setIdType($this->id_type);
        $lookup->setSearchIndex('All');
        $lookup->setResponseGroup(array('Large', 'Small'));

        $this->conf->setResponseTransformer('\ApaiIO\ResponseTransformer\XmlToDomDocument');
        $this->dom = $apaiIO->runOperation($lookup);
    }

    public function getDOM()
    {
        return $this->dom;
    }

    public function saveToXML()
    {
        $this->dom->formatOutput = true;
        $filename = $this->item_id . '.xml';

        echo 'Wrote: ' . $this->dom->save($filename) . ' bytes';
    }

    public function success()
    {
        if ($this->dom->getElementsByTagName('Item')->length == 0)
        {
            return false;
        }

        return true;
    }

    public function getValuesByTag($tag)
    {
        $elems = $this->getItem(0)->getElementsByTagName($tag);
        $values = array();

        foreach ($elems as $elem)
        {
            $values[] = $elem->nodeValue;
        }

        return $values;
    }

    public function getItem($index)
    {
        return $this->dom->getElementsByTagName('Item')->item($index);
    }

    public function getAuthors()
    {
        return $this->getValuesByTag('Author');
    }

    public function getBinding()
    {
        return $this->getValuesByTag('Binding')[0];
    }

    public function getLanguage()
    {
        $language = $this->dom->getElementsByTagName('Language')->item(0);
        $language_name = $language->getElementsByTagName('Name')->item(0)->nodeValue;
        return $language_name;
    }

    public function getNumPages()
    {
        return $this->getValuesByTag('NumberOfPages')[0];
    }

    public function getTitle()
    {
        return $this->getValuesByTag('Title')[0];
    }

    public function getEdition()
    {
        $edition = $this->getValuesByTag('Edition');

        if (count($edition) > 0)
        {
            return $edition[0];
        }
        else
        {
            return AmazonLookUp::DEFAULT_EDITION;
        }
    }

    public function getImageURL($image_size)
    {
        if ($this->getItem(0)->getElementsByTagName($image_size)->length > 0)
        {
            $image = $this->getItem(0)->getElementsByTagName($image_size)->item(0);
            $url = $image->getElementsByTagName('URL')->item(0)->nodeValue;

            return $url;
        }

        return "";
    }

    public function getSmallImage()
    {
        return $this->getImageURL('SmallImage');
    }

    public function getMediumImage()
    {
        return $this->getImageURL('MediumImage');
    }

    public function getLargeImage()
    {
        return $this->getImageURL('LargeImage');
    }

}

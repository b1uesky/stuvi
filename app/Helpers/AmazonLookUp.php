<?php namespace App\Helpers;

use Config;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\ApaiIO;

class AmazonLookUp
{
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
                ->setAccessKey(Config::get('amazon.access_key_id'))
                ->setSecretKey(Config::get('amazon.secret_access_key'))
                ->setAssociateTag(Config::get('amazon.associate_id'));
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
        $elems = $this->dom->getElementsByTagName($tag);
        $values = array();

        foreach ($elems as $elem)
        {
            $values[] = $elem->nodeValue;
        }

        return $values;
    }

    public function getAuthors()
    {
        return $this->getValuesByTag('Author');
    }

    public function getBinding()
    {
        return $this->getValuesByTag('Binding')[0];
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
        return $this->getValuesByTag('Edition')[0];
    }
}

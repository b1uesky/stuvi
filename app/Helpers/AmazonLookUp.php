<?php namespace App\Helpers;

use Config;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\ApaiIO;

class AmazonLookUp
{
    const DEFAULT_EDITION = 1;

    /**
     * For example, $amazon = new AmazonLookUp('032157351X', 'ISBN');
     *
     * @param $item_id
     * @param $id_type
     */
    public function __construct($item_id, $id_type)
    {
        $this->item_id = $item_id;
        $this->id_type = $id_type;
        $this->config();
        $this->lookUp();
    }

    /**
     * API configuration.
     */
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

    /**
     * API request. Save the DOM object.
     *
     * @throws \Exception
     */
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

    /**
     * Convert DOM to XML and save it in the root directory.
     */
    public function saveToXML()
    {
        $this->dom->formatOutput = true;
        $filename = $this->item_id . '.xml';

        echo 'Wrote: ' . $this->dom->save($filename) . ' bytes';
    }

    /**
     * Return if the response is valid by checking if it contains any <Item>.
     *
     * @return bool
     */
    public function success()
    {
        if ($this->dom->getElementsByTagName('Item')->length == 0)
        {
            return false;
        }

        return true;
    }

    /**
     * Return all the tag values.
     *
     * @param $tag
     * @return array
     */
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

    /**
     * Get a specific <Item> given the index.
     *
     * @param $index
     * @return mixed
     */
    public function getItem($index)
    {
        return $this->dom->getElementsByTagName('Item')->item($index);
    }

    /**
     * Get book authors.
     *
     * @return array
     */
    public function getAuthors()
    {
        return $this->getValuesByTag('Author');
    }

    /**
     * Get book binding.
     *
     * @return mixed
     */
    public function getBinding()
    {
        return $this->getValuesByTag('Binding')[0];
    }

    /**
     * Get book language.
     *
     * @return mixed
     */
    public function getLanguage()
    {
        $language = $this->dom->getElementsByTagName('Language')->item(0);
        $language_name = $language->getElementsByTagName('Name')->item(0)->nodeValue;
        return $language_name;
    }

    /**
     * Get the number of pages.
     *
     * @return mixed
     */
    public function getNumPages()
    {
        return $this->getValuesByTag('NumberOfPages')[0];
    }

    /**
     * Get book title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getValuesByTag('Title')[0];
    }

    /**
     * Get book edition. Default edition 1.
     *
     * @return int
     */
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

    /**
     * Get the image url given the image size.
     *
     * @param $image_size
     * @return string|null
     */
    public function getImageURL($image_size)
    {
        if ($this->getItem(0)->getElementsByTagName($image_size)->length > 0)
        {
            $image = $this->getItem(0)->getElementsByTagName($image_size)->item(0);
            $url = $image->getElementsByTagName('URL')->item(0)->nodeValue;

            return $url;
        }

        return null;
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

    /**
     * Get 10-digits ISBN.
     *
     * @return mixed
     */
    public function getISBN10()
    {
        return $this->getValuesByTag('ASIN')[0];
    }

    /**
     * Get 13-digits ISBN.
     *
     * @return mixed
     */
    public function getISBN13()
    {
        return $this->getValuesByTag('EAN')[0];
    }

    /*
    |--------------------------------------------------------------------------
    | Price
    |--------------------------------------------------------------------------
    |
    | 3 tags: ListPrice, LowestNewPrice, LowestUsedPrice
    |
    |   <Amount>1599</Amount>
    |   <CurrencyCode>USD</CurrencyCode>
    |   <FormattedPrice>$15.99</FormattedPrice>
    |
    */
    public function getPrice($tag)
    {
        if ($this->getItem(0)->getElementsByTagName($tag)->length > 0)
        {
            return $this->getItem(0)->getElementsByTagName($tag)->item(0);
        }

        return null;
    }

    /**
     * Get <ListPrice> element.
     *
     * @return mixed
     */
    public function getListPrice()
    {
        return $this->getPrice('ListPrice');
    }

    /**
     * Get <LowestNewPrice> element.
     *
     * @return mixed
     */
    public function getLowestNewPrice()
    {
        return $this->getPrice('LowestNewPrice');
    }

    /**
     * Get <LowestUsedPrice> element.
     *
     * @return mixed
     */
    public function getLowestUsedPrice()
    {
        return $this->getPrice('LowestUsedPrice');
    }

    /**
     * Get list price <Amount> value.
     *
     * @return mixed
     */
    public function getListPriceAmount()
    {
        if ($this->getListPrice())
        {
            return $this->getListPrice()->getElementsByTagName('Amount')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get list price <CurrencyCode> value.
     *
     * @return mixed
     */
    public function getListPriceCurrencyCode()
    {
        if ($this->getListPrice())
        {
            return $this->getListPrice()->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
        }

        return null;    }

    /**
     * Get list price <FormattedPrice> value.
     *
     * @return mixed
     */
    public function getListPriceFormattedPrice()
    {
        if ($this->getListPrice())
        {
            return $this->getListPrice()->getElementsByTagName('FormattedPrice')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get list price decimal value.
     *
     * @return float
     */
    public function getListPriceDecimalPrice()
    {
        return $this->getDecimalPrice($this->getListPriceFormattedPrice());
    }

    /**
 * Get lowest new price <Amount> value.
 *
 * @return mixed
 */
    public function getLowestNewPriceAmount()
    {
        if ($this->getLowestNewPrice())
        {
            return $this->getLowestNewPrice()->getElementsByTagName('Amount')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get lowest new price <CurrencyCode> value.
     *
     * @return mixed
     */
    public function getLowestNewPriceCurrencyCode()
    {
        if ($this->getLowestNewPrice())
        {
            return $this->getLowestNewPrice()->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get lowest new price <FormattedPrice> value.
     *
     * @return mixed
     */
    public function getLowestNewPriceFormattedPrice()
    {
        if ($this->getLowestNewPrice())
        {
            return $this->getLowestNewPrice()->getElementsByTagName('FormattedPrice')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get lowest new price decimal value.
     *
     * @return float
     */
    public function getLowestNewPriceDecimalPrice()
    {;
        return $this->getDecimalPrice($this->getLowestNewPriceFormattedPrice());
    }

    /**
     * Get lowest used price <Amount> value.
     *
     * @return mixed
     */
    public function getLowestUsedriceAmount()
    {
        if ($this->getLowestUsedPrice())
        {
            return $this->getLowestUsedPrice()->getElementsByTagName('Amount')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get lowest used price <CurrencyCode> value.
     *
     * @return mixed
     */
    public function getLowestUsedriceCurrencyCode()
    {
        if ($this->getLowestUsedPrice())
        {
            return $this->getLowestUsedPrice()->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get lowest used price <FormattedPrice> value.
     *
     * @return mixed
     */
    public function getLowestUsedriceFormattedPrice()
    {
        if ($this->getLowestUsedPrice())
        {
            return $this->getLowestUsedPrice()->getElementsByTagName('FormattedPrice')->item(0)->nodeValue;
        }

        return null;
    }

    /**
     * Get lowest used price decimal value.
     *
     * @return float
     */
    public function getLowestUsedriceDecimalPrice()
    {;
        return $this->getDecimalPrice($this->getLowestUsedriceFormattedPrice());
    }

    /**
     * Remove dollar sign of the price and return the decimal value of the price.
     *
     * @param $price
     * @return float
     */
    public function getDecimalPrice($price)
    {
        if ($price)
        {
            return floatval(str_replace('$', '', $price));
        }

        return null;
    }
}

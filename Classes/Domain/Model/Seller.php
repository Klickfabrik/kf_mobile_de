<?php
namespace Klickfabrik\KfMobileDe\Domain\Model;

/***
 *
 * This file is part of the "KF - Mobile.de" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Marc Finnern <typo3@klickfabrik.net>, Klickfabrik
 *
 ***/

/**
 * Seller
 */
class Seller extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * companyName
     *
     * @var string
     * @validate NotEmpty
     */
    protected $companyName = '';

    /**
     * phone
     *
     * @var string
     */
    protected $phone = '';

    /**
     * street
     *
     * @var string
     */
    protected $street = '';

    /**
     * zipcode
     *
     * @var string
     */
    protected $zipcode = '';

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * countryCode
     *
     * @var string
     */
    protected $countryCode = '';

    /**
     * latitude
     *
     * @var string
     */
    protected $latitude = '';

    /**
     * longitude
     *
     * @var string
     */
    protected $longitude = '';

    /**
     * sellerImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $sellerImage = null;

    /**
     * url
     *
     * @var string
     */
    protected $url = '';

    /**
     * email
     *
     * @var string
     */
    protected $email = '';

    /**
     * commercial
     *
     * @var bool
     */
    protected $commercial = false;

    /**
     * importKey
     *
     * @var string
     * @validate NotEmpty
     */
    protected $importKey = '';

    /**
     * import
     *
     * @var bool
     */
    protected $import = false;

    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns the commercial
     *
     * @return bool $commercial
     */
    public function getCommercial()
    {
        return $this->commercial;
    }

    /**
     * Sets the commercial
     *
     * @param bool $commercial
     * @return void
     */
    public function setCommercial($commercial)
    {
        $this->commercial = $commercial;
    }

    /**
     * Returns the boolean state of commercial
     *
     * @return bool
     */
    public function isCommercial()
    {
        return $this->commercial;
    }

    /**
     * Returns the zipcode
     *
     * @return string $zipcode
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Sets the zipcode
     *
     * @param string $zipcode
     * @return void
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the countryCode
     *
     * @return string $countryCode
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Sets the countryCode
     *
     * @param string $countryCode
     * @return void
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * Returns the latitude
     *
     * @return string $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param string $latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the longitude
     *
     * @return string $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param string $longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the importKey
     *
     * @return string importKey
     */
    public function getImportKey()
    {
        return $this->importKey;
    }

    /**
     * Sets the importKey
     *
     * @param string $importKey
     * @return void
     */
    public function setImportKey($importKey)
    {
        $this->importKey = $importKey;
    }

    /**
     * Returns the companyName
     *
     * @return string $companyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Sets the companyName
     *
     * @param string $companyName
     * @return void
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * Returns the phone
     *
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns the street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Returns the import
     *
     * @return bool $import
     */
    public function getImport()
    {
        return $this->import;
    }

    /**
     * Sets the import
     *
     * @param bool $import
     * @return void
     */
    public function setImport($import)
    {
        $this->import = $import;
    }

    /**
     * Returns the boolean state of import
     *
     * @return bool
     */
    public function isImport()
    {
        return $this->import;
    }

    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the sellerImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $sellerImage
     */
    public function getSellerImage()
    {
        return $this->sellerImage;
    }

    /**
     * Sets the sellerImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $sellerImage
     * @return void
     */
    public function setSellerImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $sellerImage)
    {
        $this->sellerImage = $sellerImage;
    }
}

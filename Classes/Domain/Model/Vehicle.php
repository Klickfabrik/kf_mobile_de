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
 * Vehicle
 */
class Vehicle extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * model description
     *
     * @var string
     * @validate NotEmpty
     */
    protected $modelDescription = '';

    /**
     * class
     *
     * @var string
     */
    protected $class = '';

    /**
     * category
     *
     * @var string
     */
    protected $category = '';

    /**
     * make
     *
     * @var string
     */
    protected $make = '';

    /**
     * model
     *
     * @var string
     */
    protected $model = '';

    /**
     * price
     *
     * @var int
     */
    protected $price = 0;

    /**
     * damage and unrepaired
     *
     * @var bool
     */
    protected $damageAndUnrepaired = false;

    /**
     * accident damaged
     *
     * @var bool
     */
    protected $accidentDamaged = false;

    /**
     * roadworthy
     *
     * @var bool
     */
    protected $roadworthy = false;

    /**
     * priceType
     *
     * @var string
     */
    protected $priceType = '';

    /**
     * fuel
     *
     * @var string
     */
    protected $fuel = '';

    /**
     * gearbox
     *
     * @var string
     */
    protected $gearbox = '';

    /**
     * color
     *
     * @var string
     */
    protected $color = false;

    /**
     * mileage
     *
     * @var string
     */
    protected $mileage = false;

    /**
     * seats
     *
     * @var string
     */
    protected $seats = false;

    /**
     * doors
     *
     * @var string
     */
    protected $doors = '';

    /**
     * power
     *
     * @var string
     */
    protected $power = false;

    /**
     * emissionClass
     *
     * @var string
     */
    protected $emissionClass = '';

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $images = null;

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * misc
     *
     * @var string
     */
    protected $misc = '';

    /**
     * consumerPriceAmount
     *
     * @var string
     */
    protected $consumerPriceAmount = '';

    /**
     * dealerPriceAmount
     *
     * @var string
     */
    protected $dealerPriceAmount = '';

    /**
     * firstRegistration
     *
     * @var \DateTime
     */
    protected $firstRegistration = null;

    /**
     * creationDate
     *
     * @var \DateTime
     */
    protected $creationDate = null;

    /**
     * modificationDate
     *
     * @var \DateTime
     */
    protected $modificationDate = null;

    /**
     * detail page from mobile.de
     *
     * @var string
     */
    protected $detailPage = '';

    /**
     * importKey
     *
     * @var string
     */
    protected $importKey = '';

    /**
     * importClient
     *
     * @var string
     */
    protected $importClient = '';

    /**
     * import
     *
     * @var bool
     */
    protected $import = false;

    /**
     * features
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Features>
     */
    protected $features = null;

    /**
     * specifics
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Specifics>
     */
    protected $specifics = null;

    /**
     * seller
     *
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Seller
     */
    protected $seller = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->features = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->specifics = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the modelDescription
     *
     * @return string $modelDescription
     */
    public function getModelDescription()
    {
        return $this->modelDescription;
    }

    /**
     * Sets the modelDescription
     *
     * @param string $modelDescription
     * @return void
     */
    public function setModelDescription($modelDescription)
    {
        $this->modelDescription = $modelDescription;
    }

    /**
     * Returns the price
     *
     * @return int $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price
     *
     * @param int $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Returns the damageAndUnrepaired
     *
     * @return bool $damageAndUnrepaired
     */
    public function getDamageAndUnrepaired()
    {
        return $this->damageAndUnrepaired;
    }

    /**
     * Sets the damageAndUnrepaired
     *
     * @param bool $damageAndUnrepaired
     * @return void
     */
    public function setDamageAndUnrepaired($damageAndUnrepaired)
    {
        $this->damageAndUnrepaired = $damageAndUnrepaired;
    }

    /**
     * Returns the boolean state of damageAndUnrepaired
     *
     * @return bool
     */
    public function isDamageAndUnrepaired()
    {
        return $this->damageAndUnrepaired;
    }

    /**
     * Returns the accidentDamaged
     *
     * @return bool $accidentDamaged
     */
    public function getAccidentDamaged()
    {
        return $this->accidentDamaged;
    }

    /**
     * Sets the accidentDamaged
     *
     * @param bool $accidentDamaged
     * @return void
     */
    public function setAccidentDamaged($accidentDamaged)
    {
        $this->accidentDamaged = $accidentDamaged;
    }

    /**
     * Returns the boolean state of accidentDamaged
     *
     * @return bool
     */
    public function isAccidentDamaged()
    {
        return $this->accidentDamaged;
    }

    /**
     * Returns the roadworthy
     *
     * @return bool $roadworthy
     */
    public function getRoadworthy()
    {
        return $this->roadworthy;
    }

    /**
     * Sets the roadworthy
     *
     * @param bool $roadworthy
     * @return void
     */
    public function setRoadworthy($roadworthy)
    {
        $this->roadworthy = $roadworthy;
    }

    /**
     * Returns the boolean state of roadworthy
     *
     * @return bool
     */
    public function isRoadworthy()
    {
        return $this->roadworthy;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->images->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove The FileReference to be removed
     * @return void
     */
    public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove)
    {
        $this->images->detach($imageToRemove);
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * Returns the detailPage
     *
     * @return string $detailPage
     */
    public function getDetailPage()
    {
        return $this->detailPage;
    }

    /**
     * Sets the detailPage
     *
     * @param string $detailPage
     * @return void
     */
    public function setDetailPage($detailPage)
    {
        $this->detailPage = $detailPage;
    }

    /**
     * Returns the creationDate
     *
     * @return \DateTime $creationDate
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Sets the creationDate
     *
     * @param \DateTime $creationDate
     * @return void
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * Returns the modificationDate
     *
     * @return \DateTime $modificationDate
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Sets the modificationDate
     *
     * @param \DateTime $modificationDate
     * @return void
     */
    public function setModificationDate(\DateTime $modificationDate)
    {
        $this->modificationDate = $modificationDate;
    }

    /**
     * Returns the category
     *
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param string $category
     * @return void
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Returns the make
     *
     * @return string $make
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Sets the make
     *
     * @param string $make
     * @return void
     */
    public function setMake($make)
    {
        $this->make = $make;
    }

    /**
     * Returns the model
     *
     * @return string $model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the model
     *
     * @param string $model
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Returns the consumerPriceAmount
     *
     * @return string $consumerPriceAmount
     */
    public function getConsumerPriceAmount()
    {
        return $this->consumerPriceAmount;
    }

    /**
     * Sets the consumerPriceAmount
     *
     * @param string $consumerPriceAmount
     * @return void
     */
    public function setConsumerPriceAmount($consumerPriceAmount)
    {
        $this->consumerPriceAmount = $consumerPriceAmount;
    }

    /**
     * Returns the dealerPriceAmount
     *
     * @return string $dealerPriceAmount
     */
    public function getDealerPriceAmount()
    {
        return $this->dealerPriceAmount;
    }

    /**
     * Sets the dealerPriceAmount
     *
     * @param string $dealerPriceAmount
     * @return void
     */
    public function setDealerPriceAmount($dealerPriceAmount)
    {
        $this->dealerPriceAmount = $dealerPriceAmount;
    }

    /**
     * Returns the priceType
     *
     * @return string $priceType
     */
    public function getPriceType()
    {
        return $this->priceType;
    }

    /**
     * Sets the priceType
     *
     * @param string $priceType
     * @return void
     */
    public function setPriceType($priceType)
    {
        $this->priceType = $priceType;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the importKey
     *
     * @return string $importKey
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
     * Returns the importClient
     *
     * @return string $importClient
     */
    public function getImportClient()
    {
        return $this->importClient;
    }

    /**
     * Sets the importClient
     *
     * @param string $importClient
     * @return void
     */
    public function setImportClient($importClient)
    {
        $this->importClient = $importClient;
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
     * Returns the fuel
     *
     * @return string $fuel
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * Sets the fuel
     *
     * @param string $fuel
     * @return void
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;
    }

    /**
     * Returns the gearbox
     *
     * @return string $gearbox
     */
    public function getGearbox()
    {
        return $this->gearbox;
    }

    /**
     * Sets the gearbox
     *
     * @param string $gearbox
     * @return void
     */
    public function setGearbox($gearbox)
    {
        $this->gearbox = $gearbox;
    }

    /**
     * Returns the misc
     *
     * @return string $misc
     */
    public function getMisc()
    {
        return $this->misc;
    }

    /**
     * Sets the misc
     *
     * @param string $misc
     * @return void
     */
    public function setMisc($misc)
    {
        $this->misc = $misc;
    }

    /**
     * Returns the color
     *
     * @return string color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets the color
     *
     * @param bool $color
     * @return void
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Returns the mileage
     *
     * @return string mileage
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Sets the mileage
     *
     * @param bool $mileage
     * @return void
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;
    }

    /**
     * Returns the seats
     *
     * @return string seats
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * Sets the seats
     *
     * @param bool $seats
     * @return void
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;
    }

    /**
     * Returns the power
     *
     * @return string power
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Sets the power
     *
     * @param bool $power
     * @return void
     */
    public function setPower($power)
    {
        $this->power = $power;
    }

    /**
     * Returns the class
     *
     * @return string class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets the class
     *
     * @param bool $class
     * @return void
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Adds a Features
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Features $feature
     * @return void
     */
    public function addFeature(\Klickfabrik\KfMobileDe\Domain\Model\Features $feature)
    {
        $this->features->attach($feature);
    }

    /**
     * Removes a Features
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Features $featureToRemove The Features to be removed
     * @return void
     */
    public function removeFeature(\Klickfabrik\KfMobileDe\Domain\Model\Features $featureToRemove)
    {
        $this->features->detach($featureToRemove);
    }

    /**
     * Returns the features
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Features> features
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Sets the features
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Features> $features
     * @return void
     */
    public function setFeatures(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $features)
    {
        $this->features = $features;
    }

    /**
     * Adds a Specifics
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Specifics $specific
     * @return void
     */
    public function addSpecific(\Klickfabrik\KfMobileDe\Domain\Model\Specifics $specific)
    {
        $this->specifics->attach($specific);
    }

    /**
     * Removes a Specifics
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Specifics $specificToRemove The Specifics to be removed
     * @return void
     */
    public function removeSpecific(\Klickfabrik\KfMobileDe\Domain\Model\Specifics $specificToRemove)
    {
        $this->specifics->detach($specificToRemove);
    }

    /**
     * Returns the specifics
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Specifics> specifics
     */
    public function getSpecifics()
    {
        return $this->specifics;
    }

    /**
     * Sets the specifics
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Specifics> $specifics
     * @return void
     */
    public function setSpecifics(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $specifics)
    {
        $this->specifics = $specifics;
    }

    /**
     * Returns the seller
     *
     * @return \Klickfabrik\KfMobileDe\Domain\Model\Seller seller
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Sets the seller
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Seller $seller
     * @return void
     */
    public function setSeller(\Klickfabrik\KfMobileDe\Domain\Model\Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Returns the doors
     *
     * @return string $doors
     */
    public function getDoors()
    {
        return $this->doors;
    }

    /**
     * Sets the doors
     *
     * @param string $doors
     * @return void
     */
    public function setDoors($doors)
    {
        $this->doors = $doors;
    }

    /**
     * Returns the emissionClass
     *
     * @return string $emissionClass
     */
    public function getEmissionClass()
    {
        return $this->emissionClass;
    }

    /**
     * Sets the emissionClass
     *
     * @param string $emissionClass
     * @return void
     */
    public function setEmissionClass($emissionClass)
    {
        $this->emissionClass = $emissionClass;
    }

    /**
     * Returns the firstRegistration
     *
     * @return \DateTime $firstRegistration
     */
    public function getFirstRegistration()
    {
        return $this->firstRegistration;
    }

    /**
     * Sets the firstRegistration
     *
     * @param \DateTime $firstRegistration
     * @return void
     */
    public function setFirstRegistration(\DateTime $firstRegistration)
    {
        $this->firstRegistration = $firstRegistration;
    }
}

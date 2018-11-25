<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class VehicleTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Vehicle
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getModelDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getModelDescription()
        );
    }

    /**
     * @test
     */
    public function setModelDescriptionForStringSetsModelDescription()
    {
        $this->subject->setModelDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'modelDescription',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getClassReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getClass()
        );
    }

    /**
     * @test
     */
    public function setClassForStringSetsClass()
    {
        $this->subject->setClass('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'class',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCategoryReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCategory()
        );
    }

    /**
     * @test
     */
    public function setCategoryForStringSetsCategory()
    {
        $this->subject->setCategory('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'category',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMakeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMake()
        );
    }

    /**
     * @test
     */
    public function setMakeForStringSetsMake()
    {
        $this->subject->setMake('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'make',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getModelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getModel()
        );
    }

    /**
     * @test
     */
    public function setModelForStringSetsModel()
    {
        $this->subject->setModel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'model',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPriceReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceForIntSetsPrice()
    {
        $this->subject->setPrice(12);

        self::assertAttributeEquals(
            12,
            'price',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDamageAndUnrepairedReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getDamageAndUnrepaired()
        );
    }

    /**
     * @test
     */
    public function setDamageAndUnrepairedForBoolSetsDamageAndUnrepaired()
    {
        $this->subject->setDamageAndUnrepaired(true);

        self::assertAttributeEquals(
            true,
            'damageAndUnrepaired',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAccidentDamagedReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getAccidentDamaged()
        );
    }

    /**
     * @test
     */
    public function setAccidentDamagedForBoolSetsAccidentDamaged()
    {
        $this->subject->setAccidentDamaged(true);

        self::assertAttributeEquals(
            true,
            'accidentDamaged',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRoadworthyReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getRoadworthy()
        );
    }

    /**
     * @test
     */
    public function setRoadworthyForBoolSetsRoadworthy()
    {
        $this->subject->setRoadworthy(true);

        self::assertAttributeEquals(
            true,
            'roadworthy',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPriceTypeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPriceType()
        );
    }

    /**
     * @test
     */
    public function setPriceTypeForStringSetsPriceType()
    {
        $this->subject->setPriceType('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'priceType',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFuelReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFuel()
        );
    }

    /**
     * @test
     */
    public function setFuelForStringSetsFuel()
    {
        $this->subject->setFuel('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'fuel',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getGearboxReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getGearbox()
        );
    }

    /**
     * @test
     */
    public function setGearboxForStringSetsGearbox()
    {
        $this->subject->setGearbox('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'gearbox',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getColorReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getColor()
        );
    }

    /**
     * @test
     */
    public function setColorForStringSetsColor()
    {
        $this->subject->setColor('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'color',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMileageReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMileage()
        );
    }

    /**
     * @test
     */
    public function setMileageForStringSetsMileage()
    {
        $this->subject->setMileage('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'mileage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSeatsReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSeats()
        );
    }

    /**
     * @test
     */
    public function setSeatsForStringSetsSeats()
    {
        $this->subject->setSeats('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'seats',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDoorsReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDoors()
        );
    }

    /**
     * @test
     */
    public function setDoorsForStringSetsDoors()
    {
        $this->subject->setDoors('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'doors',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPowerReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPower()
        );
    }

    /**
     * @test
     */
    public function setPowerForStringSetsPower()
    {
        $this->subject->setPower('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'power',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEmissionClassReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmissionClass()
        );
    }

    /**
     * @test
     */
    public function setEmissionClassForStringSetsEmissionClass()
    {
        $this->subject->setEmissionClass('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'emissionClass',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImagesReturnsInitialValueForFileReference()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getImages()
        );
    }

    /**
     * @test
     */
    public function setImagesForFileReferenceSetsImages()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneImages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneImages->attach($image);
        $this->subject->setImages($objectStorageHoldingExactlyOneImages);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneImages,
            'images',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addImageToObjectStorageHoldingImages()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imagesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imagesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($image));
        $this->inject($this->subject, 'images', $imagesObjectStorageMock);

        $this->subject->addImage($image);
    }

    /**
     * @test
     */
    public function removeImageFromObjectStorageHoldingImages()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imagesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imagesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($image));
        $this->inject($this->subject, 'images', $imagesObjectStorageMock);

        $this->subject->removeImage($image);
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMiscReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMisc()
        );
    }

    /**
     * @test
     */
    public function setMiscForStringSetsMisc()
    {
        $this->subject->setMisc('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'misc',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConsumerPriceAmountReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getConsumerPriceAmount()
        );
    }

    /**
     * @test
     */
    public function setConsumerPriceAmountForStringSetsConsumerPriceAmount()
    {
        $this->subject->setConsumerPriceAmount('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'consumerPriceAmount',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDealerPriceAmountReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDealerPriceAmount()
        );
    }

    /**
     * @test
     */
    public function setDealerPriceAmountForStringSetsDealerPriceAmount()
    {
        $this->subject->setDealerPriceAmount('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'dealerPriceAmount',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFirstRegistrationReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getFirstRegistration()
        );
    }

    /**
     * @test
     */
    public function setFirstRegistrationForDateTimeSetsFirstRegistration()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setFirstRegistration($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'firstRegistration',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCreationDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getCreationDate()
        );
    }

    /**
     * @test
     */
    public function setCreationDateForDateTimeSetsCreationDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setCreationDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'creationDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getModificationDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getModificationDate()
        );
    }

    /**
     * @test
     */
    public function setModificationDateForDateTimeSetsModificationDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setModificationDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'modificationDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDetailPageReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDetailPage()
        );
    }

    /**
     * @test
     */
    public function setDetailPageForStringSetsDetailPage()
    {
        $this->subject->setDetailPage('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'detailPage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImportKeyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getImportKey()
        );
    }

    /**
     * @test
     */
    public function setImportKeyForStringSetsImportKey()
    {
        $this->subject->setImportKey('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'importKey',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImportClientReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getImportClient()
        );
    }

    /**
     * @test
     */
    public function setImportClientForStringSetsImportClient()
    {
        $this->subject->setImportClient('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'importClient',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImportReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getImport()
        );
    }

    /**
     * @test
     */
    public function setImportForBoolSetsImport()
    {
        $this->subject->setImport(true);

        self::assertAttributeEquals(
            true,
            'import',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFeaturesReturnsInitialValueForFeatures()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getFeatures()
        );
    }

    /**
     * @test
     */
    public function setFeaturesForObjectStorageContainingFeaturesSetsFeatures()
    {
        $feature = new \Klickfabrik\KfMobileDe\Domain\Model\Features();
        $objectStorageHoldingExactlyOneFeatures = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFeatures->attach($feature);
        $this->subject->setFeatures($objectStorageHoldingExactlyOneFeatures);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneFeatures,
            'features',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addFeatureToObjectStorageHoldingFeatures()
    {
        $feature = new \Klickfabrik\KfMobileDe\Domain\Model\Features();
        $featuresObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $featuresObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($feature));
        $this->inject($this->subject, 'features', $featuresObjectStorageMock);

        $this->subject->addFeature($feature);
    }

    /**
     * @test
     */
    public function removeFeatureFromObjectStorageHoldingFeatures()
    {
        $feature = new \Klickfabrik\KfMobileDe\Domain\Model\Features();
        $featuresObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $featuresObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($feature));
        $this->inject($this->subject, 'features', $featuresObjectStorageMock);

        $this->subject->removeFeature($feature);
    }

    /**
     * @test
     */
    public function getSpecificsReturnsInitialValueForSpecifics()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getSpecifics()
        );
    }

    /**
     * @test
     */
    public function setSpecificsForObjectStorageContainingSpecificsSetsSpecifics()
    {
        $specific = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();
        $objectStorageHoldingExactlyOneSpecifics = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneSpecifics->attach($specific);
        $this->subject->setSpecifics($objectStorageHoldingExactlyOneSpecifics);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneSpecifics,
            'specifics',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addSpecificToObjectStorageHoldingSpecifics()
    {
        $specific = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();
        $specificsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $specificsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($specific));
        $this->inject($this->subject, 'specifics', $specificsObjectStorageMock);

        $this->subject->addSpecific($specific);
    }

    /**
     * @test
     */
    public function removeSpecificFromObjectStorageHoldingSpecifics()
    {
        $specific = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();
        $specificsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $specificsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($specific));
        $this->inject($this->subject, 'specifics', $specificsObjectStorageMock);

        $this->subject->removeSpecific($specific);
    }

    /**
     * @test
     */
    public function getSellerReturnsInitialValueForSeller()
    {
        self::assertEquals(
            null,
            $this->subject->getSeller()
        );
    }

    /**
     * @test
     */
    public function setSellerForSellerSetsSeller()
    {
        $sellerFixture = new \Klickfabrik\KfMobileDe\Domain\Model\Seller();
        $this->subject->setSeller($sellerFixture);

        self::assertAttributeEquals(
            $sellerFixture,
            'seller',
            $this->subject
        );
    }
}

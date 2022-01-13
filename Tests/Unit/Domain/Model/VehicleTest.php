<?php

declare(strict_types=1);

namespace Klickfabrik\KfMobileDe\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class VehicleTest extends UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Vehicle|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Klickfabrik\KfMobileDe\Domain\Model\Vehicle::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getModelDescriptionReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getModelDescription()
        );
    }

    /**
     * @test
     */
    public function setModelDescriptionForStringSetsModelDescription(): void
    {
        $this->subject->setModelDescription('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('modelDescription'));
    }

    /**
     * @test
     */
    public function getClassReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getClass()
        );
    }

    /**
     * @test
     */
    public function setClassForStringSetsClass(): void
    {
        $this->subject->setClass('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('class'));
    }

    /**
     * @test
     */
    public function getCategoryReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCategory()
        );
    }

    /**
     * @test
     */
    public function setCategoryForStringSetsCategory(): void
    {
        $this->subject->setCategory('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('category'));
    }

    /**
     * @test
     */
    public function getMakeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getMake()
        );
    }

    /**
     * @test
     */
    public function setMakeForStringSetsMake(): void
    {
        $this->subject->setMake('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('make'));
    }

    /**
     * @test
     */
    public function getModelReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getModel()
        );
    }

    /**
     * @test
     */
    public function setModelForStringSetsModel(): void
    {
        $this->subject->setModel('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('model'));
    }

    /**
     * @test
     */
    public function getPriceReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceForIntSetsPrice(): void
    {
        $this->subject->setPrice(12);

        self::assertEquals(12, $this->subject->_get('price'));
    }

    /**
     * @test
     */
    public function getDamageAndUnrepairedReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getDamageAndUnrepaired());
    }

    /**
     * @test
     */
    public function setDamageAndUnrepairedForBoolSetsDamageAndUnrepaired(): void
    {
        $this->subject->setDamageAndUnrepaired(true);

        self::assertEquals(true, $this->subject->_get('damageAndUnrepaired'));
    }

    /**
     * @test
     */
    public function getAccidentDamagedReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getAccidentDamaged());
    }

    /**
     * @test
     */
    public function setAccidentDamagedForBoolSetsAccidentDamaged(): void
    {
        $this->subject->setAccidentDamaged(true);

        self::assertEquals(true, $this->subject->_get('accidentDamaged'));
    }

    /**
     * @test
     */
    public function getRoadworthyReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getRoadworthy());
    }

    /**
     * @test
     */
    public function setRoadworthyForBoolSetsRoadworthy(): void
    {
        $this->subject->setRoadworthy(true);

        self::assertEquals(true, $this->subject->_get('roadworthy'));
    }

    /**
     * @test
     */
    public function getPriceTypeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPriceType()
        );
    }

    /**
     * @test
     */
    public function setPriceTypeForStringSetsPriceType(): void
    {
        $this->subject->setPriceType('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('priceType'));
    }

    /**
     * @test
     */
    public function getFuelReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFuel()
        );
    }

    /**
     * @test
     */
    public function setFuelForStringSetsFuel(): void
    {
        $this->subject->setFuel('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('fuel'));
    }

    /**
     * @test
     */
    public function getGearboxReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getGearbox()
        );
    }

    /**
     * @test
     */
    public function setGearboxForStringSetsGearbox(): void
    {
        $this->subject->setGearbox('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('gearbox'));
    }

    /**
     * @test
     */
    public function getColorReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getColor()
        );
    }

    /**
     * @test
     */
    public function setColorForStringSetsColor(): void
    {
        $this->subject->setColor('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('color'));
    }

    /**
     * @test
     */
    public function getMileageReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getMileage()
        );
    }

    /**
     * @test
     */
    public function setMileageForStringSetsMileage(): void
    {
        $this->subject->setMileage('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('mileage'));
    }

    /**
     * @test
     */
    public function getSeatsReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSeats()
        );
    }

    /**
     * @test
     */
    public function setSeatsForStringSetsSeats(): void
    {
        $this->subject->setSeats('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('seats'));
    }

    /**
     * @test
     */
    public function getDoorsReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDoors()
        );
    }

    /**
     * @test
     */
    public function setDoorsForStringSetsDoors(): void
    {
        $this->subject->setDoors('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('doors'));
    }

    /**
     * @test
     */
    public function getPowerReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPower()
        );
    }

    /**
     * @test
     */
    public function setPowerForStringSetsPower(): void
    {
        $this->subject->setPower('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('power'));
    }

    /**
     * @test
     */
    public function getCubicCapacityReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCubicCapacity()
        );
    }

    /**
     * @test
     */
    public function setCubicCapacityForStringSetsCubicCapacity(): void
    {
        $this->subject->setCubicCapacity('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('cubicCapacity'));
    }

    /**
     * @test
     */
    public function getEmissionClassReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEmissionClass()
        );
    }

    /**
     * @test
     */
    public function setEmissionClassForStringSetsEmissionClass(): void
    {
        $this->subject->setEmissionClass('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('emissionClass'));
    }

    /**
     * @test
     */
    public function getImagesReturnsInitialValueForFileReference(): void
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
    public function setImagesForFileReferenceSetsImages(): void
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneImages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneImages->attach($image);
        $this->subject->setImages($objectStorageHoldingExactlyOneImages);

        self::assertEquals($objectStorageHoldingExactlyOneImages, $this->subject->_get('images'));
    }

    /**
     * @test
     */
    public function addImageToObjectStorageHoldingImages(): void
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imagesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imagesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($image));
        $this->subject->_set('images', $imagesObjectStorageMock);

        $this->subject->addImage($image);
    }

    /**
     * @test
     */
    public function removeImageFromObjectStorageHoldingImages(): void
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imagesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imagesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($image));
        $this->subject->_set('images', $imagesObjectStorageMock);

        $this->subject->removeImage($image);
    }

    /**
     * @test
     */
    public function getImageDataReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getImageData()
        );
    }

    /**
     * @test
     */
    public function setImageDataForStringSetsImageData(): void
    {
        $this->subject->setImageData('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('imageData'));
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription(): void
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('description'));
    }

    /**
     * @test
     */
    public function getMiscReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getMisc()
        );
    }

    /**
     * @test
     */
    public function setMiscForStringSetsMisc(): void
    {
        $this->subject->setMisc('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('misc'));
    }

    /**
     * @test
     */
    public function getConsumerPriceAmountReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getConsumerPriceAmount()
        );
    }

    /**
     * @test
     */
    public function setConsumerPriceAmountForStringSetsConsumerPriceAmount(): void
    {
        $this->subject->setConsumerPriceAmount('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('consumerPriceAmount'));
    }

    /**
     * @test
     */
    public function getDealerPriceAmountReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDealerPriceAmount()
        );
    }

    /**
     * @test
     */
    public function setDealerPriceAmountForStringSetsDealerPriceAmount(): void
    {
        $this->subject->setDealerPriceAmount('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('dealerPriceAmount'));
    }

    /**
     * @test
     */
    public function getFirstRegistrationReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getFirstRegistration()
        );
    }

    /**
     * @test
     */
    public function setFirstRegistrationForDateTimeSetsFirstRegistration(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setFirstRegistration($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('firstRegistration'));
    }

    /**
     * @test
     */
    public function getCreationDateReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getCreationDate()
        );
    }

    /**
     * @test
     */
    public function setCreationDateForDateTimeSetsCreationDate(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setCreationDate($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('creationDate'));
    }

    /**
     * @test
     */
    public function getModificationDateReturnsInitialValueForDateTime(): void
    {
        self::assertEquals(
            null,
            $this->subject->getModificationDate()
        );
    }

    /**
     * @test
     */
    public function setModificationDateForDateTimeSetsModificationDate(): void
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setModificationDate($dateTimeFixture);

        self::assertEquals($dateTimeFixture, $this->subject->_get('modificationDate'));
    }

    /**
     * @test
     */
    public function getDetailPageReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDetailPage()
        );
    }

    /**
     * @test
     */
    public function setDetailPageForStringSetsDetailPage(): void
    {
        $this->subject->setDetailPage('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('detailPage'));
    }

    /**
     * @test
     */
    public function getImportKeyReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getImportKey()
        );
    }

    /**
     * @test
     */
    public function setImportKeyForStringSetsImportKey(): void
    {
        $this->subject->setImportKey('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('importKey'));
    }

    /**
     * @test
     */
    public function getImportClientReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getImportClient()
        );
    }

    /**
     * @test
     */
    public function setImportClientForStringSetsImportClient(): void
    {
        $this->subject->setImportClient('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('importClient'));
    }

    /**
     * @test
     */
    public function getImportReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getImport());
    }

    /**
     * @test
     */
    public function setImportForBoolSetsImport(): void
    {
        $this->subject->setImport(true);

        self::assertEquals(true, $this->subject->_get('import'));
    }

    /**
     * @test
     */
    public function getCustom1ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCustom1()
        );
    }

    /**
     * @test
     */
    public function setCustom1ForStringSetsCustom1(): void
    {
        $this->subject->setCustom1('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('custom1'));
    }

    /**
     * @test
     */
    public function getCustom2ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCustom2()
        );
    }

    /**
     * @test
     */
    public function setCustom2ForStringSetsCustom2(): void
    {
        $this->subject->setCustom2('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('custom2'));
    }

    /**
     * @test
     */
    public function getCustom3ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCustom3()
        );
    }

    /**
     * @test
     */
    public function setCustom3ForStringSetsCustom3(): void
    {
        $this->subject->setCustom3('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('custom3'));
    }

    /**
     * @test
     */
    public function getCustom4ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCustom4()
        );
    }

    /**
     * @test
     */
    public function setCustom4ForStringSetsCustom4(): void
    {
        $this->subject->setCustom4('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('custom4'));
    }

    /**
     * @test
     */
    public function getCustom5ReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCustom5()
        );
    }

    /**
     * @test
     */
    public function setCustom5ForStringSetsCustom5(): void
    {
        $this->subject->setCustom5('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('custom5'));
    }

    /**
     * @test
     */
    public function getSlugReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSlug()
        );
    }

    /**
     * @test
     */
    public function setSlugForStringSetsSlug(): void
    {
        $this->subject->setSlug('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('slug'));
    }

    /**
     * @test
     */
    public function getFeaturesReturnsInitialValueForFeatures(): void
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
    public function setFeaturesForObjectStorageContainingFeaturesSetsFeatures(): void
    {
        $feature = new \Klickfabrik\KfMobileDe\Domain\Model\Features();
        $objectStorageHoldingExactlyOneFeatures = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFeatures->attach($feature);
        $this->subject->setFeatures($objectStorageHoldingExactlyOneFeatures);

        self::assertEquals($objectStorageHoldingExactlyOneFeatures, $this->subject->_get('features'));
    }

    /**
     * @test
     */
    public function addFeatureToObjectStorageHoldingFeatures(): void
    {
        $feature = new \Klickfabrik\KfMobileDe\Domain\Model\Features();
        $featuresObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $featuresObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($feature));
        $this->subject->_set('features', $featuresObjectStorageMock);

        $this->subject->addFeature($feature);
    }

    /**
     * @test
     */
    public function removeFeatureFromObjectStorageHoldingFeatures(): void
    {
        $feature = new \Klickfabrik\KfMobileDe\Domain\Model\Features();
        $featuresObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $featuresObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($feature));
        $this->subject->_set('features', $featuresObjectStorageMock);

        $this->subject->removeFeature($feature);
    }

    /**
     * @test
     */
    public function getSpecificsReturnsInitialValueForSpecifics(): void
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
    public function setSpecificsForObjectStorageContainingSpecificsSetsSpecifics(): void
    {
        $specific = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();
        $objectStorageHoldingExactlyOneSpecifics = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneSpecifics->attach($specific);
        $this->subject->setSpecifics($objectStorageHoldingExactlyOneSpecifics);

        self::assertEquals($objectStorageHoldingExactlyOneSpecifics, $this->subject->_get('specifics'));
    }

    /**
     * @test
     */
    public function addSpecificToObjectStorageHoldingSpecifics(): void
    {
        $specific = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();
        $specificsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $specificsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($specific));
        $this->subject->_set('specifics', $specificsObjectStorageMock);

        $this->subject->addSpecific($specific);
    }

    /**
     * @test
     */
    public function removeSpecificFromObjectStorageHoldingSpecifics(): void
    {
        $specific = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();
        $specificsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->onlyMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $specificsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($specific));
        $this->subject->_set('specifics', $specificsObjectStorageMock);

        $this->subject->removeSpecific($specific);
    }

    /**
     * @test
     */
    public function getSellerReturnsInitialValueForSeller(): void
    {
        self::assertEquals(
            null,
            $this->subject->getSeller()
        );
    }

    /**
     * @test
     */
    public function setSellerForSellerSetsSeller(): void
    {
        $sellerFixture = new \Klickfabrik\KfMobileDe\Domain\Model\Seller();
        $this->subject->setSeller($sellerFixture);

        self::assertEquals($sellerFixture, $this->subject->_get('seller'));
    }
}

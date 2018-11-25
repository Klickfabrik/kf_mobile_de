<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class SellerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Seller
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Klickfabrik\KfMobileDe\Domain\Model\Seller();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getCompanyNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCompanyName()
        );
    }

    /**
     * @test
     */
    public function setCompanyNameForStringSetsCompanyName()
    {
        $this->subject->setCompanyName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'companyName',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPhoneReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPhone()
        );
    }

    /**
     * @test
     */
    public function setPhoneForStringSetsPhone()
    {
        $this->subject->setPhone('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'phone',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStreetReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStreet()
        );
    }

    /**
     * @test
     */
    public function setStreetForStringSetsStreet()
    {
        $this->subject->setStreet('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'street',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getZipcodeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getZipcode()
        );
    }

    /**
     * @test
     */
    public function setZipcodeForStringSetsZipcode()
    {
        $this->subject->setZipcode('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'zipcode',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCityReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCity()
        );
    }

    /**
     * @test
     */
    public function setCityForStringSetsCity()
    {
        $this->subject->setCity('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'city',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCountryCodeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCountryCode()
        );
    }

    /**
     * @test
     */
    public function setCountryCodeForStringSetsCountryCode()
    {
        $this->subject->setCountryCode('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'countryCode',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLatitudeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLatitude()
        );
    }

    /**
     * @test
     */
    public function setLatitudeForStringSetsLatitude()
    {
        $this->subject->setLatitude('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'latitude',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLongitudeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLongitude()
        );
    }

    /**
     * @test
     */
    public function setLongitudeForStringSetsLongitude()
    {
        $this->subject->setLongitude('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'longitude',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSellerImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getSellerImage()
        );
    }

    /**
     * @test
     */
    public function setSellerImageForFileReferenceSetsSellerImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setSellerImage($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'sellerImage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUrlReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUrl()
        );
    }

    /**
     * @test
     */
    public function setUrlForStringSetsUrl()
    {
        $this->subject->setUrl('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'url',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'email',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCommercialReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getCommercial()
        );
    }

    /**
     * @test
     */
    public function setCommercialForBoolSetsCommercial()
    {
        $this->subject->setCommercial(true);

        self::assertAttributeEquals(
            true,
            'commercial',
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
}

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
class SellerTest extends UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Seller|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Klickfabrik\KfMobileDe\Domain\Model\Seller::class,
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
    public function getCompanyNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCompanyName()
        );
    }

    /**
     * @test
     */
    public function setCompanyNameForStringSetsCompanyName(): void
    {
        $this->subject->setCompanyName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('companyName'));
    }

    /**
     * @test
     */
    public function getPhoneReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPhone()
        );
    }

    /**
     * @test
     */
    public function setPhoneForStringSetsPhone(): void
    {
        $this->subject->setPhone('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('phone'));
    }

    /**
     * @test
     */
    public function getStreetReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getStreet()
        );
    }

    /**
     * @test
     */
    public function setStreetForStringSetsStreet(): void
    {
        $this->subject->setStreet('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('street'));
    }

    /**
     * @test
     */
    public function getZipcodeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getZipcode()
        );
    }

    /**
     * @test
     */
    public function setZipcodeForStringSetsZipcode(): void
    {
        $this->subject->setZipcode('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('zipcode'));
    }

    /**
     * @test
     */
    public function getCityReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCity()
        );
    }

    /**
     * @test
     */
    public function setCityForStringSetsCity(): void
    {
        $this->subject->setCity('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('city'));
    }

    /**
     * @test
     */
    public function getCountryCodeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getCountryCode()
        );
    }

    /**
     * @test
     */
    public function setCountryCodeForStringSetsCountryCode(): void
    {
        $this->subject->setCountryCode('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('countryCode'));
    }

    /**
     * @test
     */
    public function getLatitudeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getLatitude()
        );
    }

    /**
     * @test
     */
    public function setLatitudeForStringSetsLatitude(): void
    {
        $this->subject->setLatitude('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('latitude'));
    }

    /**
     * @test
     */
    public function getLongitudeReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getLongitude()
        );
    }

    /**
     * @test
     */
    public function setLongitudeForStringSetsLongitude(): void
    {
        $this->subject->setLongitude('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('longitude'));
    }

    /**
     * @test
     */
    public function getSellerImageReturnsInitialValueForFileReference(): void
    {
        self::assertEquals(
            null,
            $this->subject->getSellerImage()
        );
    }

    /**
     * @test
     */
    public function setSellerImageForFileReferenceSetsSellerImage(): void
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setSellerImage($fileReferenceFixture);

        self::assertEquals($fileReferenceFixture, $this->subject->_get('sellerImage'));
    }

    /**
     * @test
     */
    public function getSellerInfoReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSellerInfo()
        );
    }

    /**
     * @test
     */
    public function setSellerInfoForStringSetsSellerInfo(): void
    {
        $this->subject->setSellerInfo('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('sellerInfo'));
    }

    /**
     * @test
     */
    public function getUrlReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getUrl()
        );
    }

    /**
     * @test
     */
    public function setUrlForStringSetsUrl(): void
    {
        $this->subject->setUrl('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('url'));
    }

    /**
     * @test
     */
    public function getEmailReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail(): void
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('email'));
    }

    /**
     * @test
     */
    public function getCommercialReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->getCommercial());
    }

    /**
     * @test
     */
    public function setCommercialForBoolSetsCommercial(): void
    {
        $this->subject->setCommercial(true);

        self::assertEquals(true, $this->subject->_get('commercial'));
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
}

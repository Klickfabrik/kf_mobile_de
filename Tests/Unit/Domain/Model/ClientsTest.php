<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class ClientsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Clients
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Klickfabrik\KfMobileDe\Domain\Model\Clients();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getIdReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getId()
        );
    }

    /**
     * @test
     */
    public function setIdForStringSetsId()
    {
        $this->subject->setId('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'id',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUsernameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUsername()
        );
    }

    /**
     * @test
     */
    public function setUsernameForStringSetsUsername()
    {
        $this->subject->setUsername('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'username',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPasswordReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPassword()
        );
    }

    /**
     * @test
     */
    public function setPasswordForStringSetsPassword()
    {
        $this->subject->setPassword('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'password',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getApikeyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getApikey()
        );
    }

    /**
     * @test
     */
    public function setApikeyForStringSetsApikey()
    {
        $this->subject->setApikey('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'apikey',
            $this->subject
        );
    }
}

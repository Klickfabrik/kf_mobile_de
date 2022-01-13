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
class ClientsTest extends UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Clients|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Klickfabrik\KfMobileDe\Domain\Model\Clients::class,
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
    public function getNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName(): void
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('name'));
    }

    /**
     * @test
     */
    public function getIdReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getId()
        );
    }

    /**
     * @test
     */
    public function setIdForStringSetsId(): void
    {
        $this->subject->setId('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('id'));
    }

    /**
     * @test
     */
    public function getUsernameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getUsername()
        );
    }

    /**
     * @test
     */
    public function setUsernameForStringSetsUsername(): void
    {
        $this->subject->setUsername('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('username'));
    }

    /**
     * @test
     */
    public function getPasswordReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getPassword()
        );
    }

    /**
     * @test
     */
    public function setPasswordForStringSetsPassword(): void
    {
        $this->subject->setPassword('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('password'));
    }

    /**
     * @test
     */
    public function getApikeyReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getApikey()
        );
    }

    /**
     * @test
     */
    public function setApikeyForStringSetsApikey(): void
    {
        $this->subject->setApikey('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('apikey'));
    }
}

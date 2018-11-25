<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class ImporterTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Model\Importer
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Klickfabrik\KfMobileDe\Domain\Model\Importer();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getImportierenReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getImportieren()
        );
    }

    /**
     * @test
     */
    public function setImportierenForIntSetsImportieren()
    {
        $this->subject->setImportieren(12);

        self::assertAttributeEquals(
            12,
            'importieren',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUpdatenReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getUpdaten()
        );
    }

    /**
     * @test
     */
    public function setUpdatenForIntSetsUpdaten()
    {
        $this->subject->setUpdaten(12);

        self::assertAttributeEquals(
            12,
            'updaten',
            $this->subject
        );
    }
}

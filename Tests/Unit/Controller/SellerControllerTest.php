<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class SellerControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Controller\SellerController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Controller\SellerController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}

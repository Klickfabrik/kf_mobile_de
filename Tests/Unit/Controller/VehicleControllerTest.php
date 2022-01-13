<?php

declare(strict_types=1);

namespace Klickfabrik\KfMobileDe\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class VehicleControllerTest extends UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Controller\VehicleController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\Klickfabrik\KfMobileDe\Controller\VehicleController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllVehiclesFromRepositoryAndAssignsThemToView(): void
    {
        $allVehicles = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $vehicleRepository = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $vehicleRepository->expects(self::once())->method('findAll')->will(self::returnValue($allVehicles));
        $this->subject->_set('vehicleRepository', $vehicleRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('vehicles', $allVehicles);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenVehicleToView(): void
    {
        $vehicle = new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('vehicle', $vehicle);

        $this->subject->showAction($vehicle);
    }
}

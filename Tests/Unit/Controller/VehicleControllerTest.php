<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class VehicleControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Controller\VehicleController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Controller\VehicleController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllVehiclesFromRepositoryAndAssignsThemToView()
    {

        $allVehicles = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $vehicleRepository = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $vehicleRepository->expects(self::once())->method('findAll')->will(self::returnValue($allVehicles));
        $this->inject($this->subject, 'vehicleRepository', $vehicleRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('vehicles', $allVehicles);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenVehicleToView()
    {
        $vehicle = new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('vehicle', $vehicle);

        $this->subject->showAction($vehicle);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenVehicleToVehicleRepository()
    {
        $vehicle = new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle();

        $vehicleRepository = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $vehicleRepository->expects(self::once())->method('add')->with($vehicle);
        $this->inject($this->subject, 'vehicleRepository', $vehicleRepository);

        $this->subject->createAction($vehicle);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenVehicleToView()
    {
        $vehicle = new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('vehicle', $vehicle);

        $this->subject->editAction($vehicle);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenVehicleInVehicleRepository()
    {
        $vehicle = new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle();

        $vehicleRepository = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $vehicleRepository->expects(self::once())->method('update')->with($vehicle);
        $this->inject($this->subject, 'vehicleRepository', $vehicleRepository);

        $this->subject->updateAction($vehicle);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenVehicleFromVehicleRepository()
    {
        $vehicle = new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle();

        $vehicleRepository = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $vehicleRepository->expects(self::once())->method('remove')->with($vehicle);
        $this->inject($this->subject, 'vehicleRepository', $vehicleRepository);

        $this->subject->deleteAction($vehicle);
    }
}

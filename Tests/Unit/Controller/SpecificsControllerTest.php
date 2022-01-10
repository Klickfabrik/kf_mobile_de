<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class SpecificsControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Controller\SpecificsController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Controller\SpecificsController::class)
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
    public function listActionFetchesAllSpecificssFromRepositoryAndAssignsThemToView()
    {

        $allSpecificss = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $specificsRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $specificsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allSpecificss));
        $this->inject($this->subject, 'specificsRepository', $specificsRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('specificss', $allSpecificss);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenSpecificsToSpecificsRepository()
    {
        $specifics = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();

        $specificsRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $specificsRepository->expects(self::once())->method('add')->with($specifics);
        $this->inject($this->subject, 'specificsRepository', $specificsRepository);

        $this->subject->createAction($specifics);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenSpecificsToView()
    {
        $specifics = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('specifics', $specifics);

        $this->subject->editAction($specifics);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenSpecificsInSpecificsRepository()
    {
        $specifics = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();

        $specificsRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $specificsRepository->expects(self::once())->method('update')->with($specifics);
        $this->inject($this->subject, 'specificsRepository', $specificsRepository);

        $this->subject->updateAction($specifics);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenSpecificsFromSpecificsRepository()
    {
        $specifics = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();

        $specificsRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $specificsRepository->expects(self::once())->method('remove')->with($specifics);
        $this->inject($this->subject, 'specificsRepository', $specificsRepository);

        $this->subject->deleteAction($specifics);
    }
}

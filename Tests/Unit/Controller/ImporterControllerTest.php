<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class ImporterControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Controller\ImporterController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Controller\ImporterController::class)
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
    public function listActionFetchesAllImportersFromRepositoryAndAssignsThemToView()
    {

        $allImporters = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $importerRepository = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Domain\Repository\ImporterRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $importerRepository->expects(self::once())->method('findAll')->will(self::returnValue($allImporters));
        $this->inject($this->subject, 'importerRepository', $importerRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('importers', $allImporters);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenImporterToView()
    {
        $importer = new \Klickfabrik\KfMobileDe\Domain\Model\Importer();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('importer', $importer);

        $this->subject->showAction($importer);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenImporterToImporterRepository()
    {
        $importer = new \Klickfabrik\KfMobileDe\Domain\Model\Importer();

        $importerRepository = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Domain\Repository\ImporterRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $importerRepository->expects(self::once())->method('add')->with($importer);
        $this->inject($this->subject, 'importerRepository', $importerRepository);

        $this->subject->createAction($importer);
    }
}

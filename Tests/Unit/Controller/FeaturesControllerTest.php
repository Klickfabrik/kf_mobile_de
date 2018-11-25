<?php
namespace Klickfabrik\KfMobileDe\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Marc Finnern <typo3@klickfabrik.net>
 */
class FeaturesControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Klickfabrik\KfMobileDe\Controller\FeaturesController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Klickfabrik\KfMobileDe\Controller\FeaturesController::class)
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
    public function listActionFetchesAllFeaturessFromRepositoryAndAssignsThemToView()
    {

        $allFeaturess = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $featuresRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $featuresRepository->expects(self::once())->method('findAll')->will(self::returnValue($allFeaturess));
        $this->inject($this->subject, 'featuresRepository', $featuresRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('featuress', $allFeaturess);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenFeaturesToFeaturesRepository()
    {
        $features = new \Klickfabrik\KfMobileDe\Domain\Model\Features();

        $featuresRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $featuresRepository->expects(self::once())->method('add')->with($features);
        $this->inject($this->subject, 'featuresRepository', $featuresRepository);

        $this->subject->createAction($features);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenFeaturesToView()
    {
        $features = new \Klickfabrik\KfMobileDe\Domain\Model\Features();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('features', $features);

        $this->subject->editAction($features);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenFeaturesInFeaturesRepository()
    {
        $features = new \Klickfabrik\KfMobileDe\Domain\Model\Features();

        $featuresRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $featuresRepository->expects(self::once())->method('update')->with($features);
        $this->inject($this->subject, 'featuresRepository', $featuresRepository);

        $this->subject->updateAction($features);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenFeaturesFromFeaturesRepository()
    {
        $features = new \Klickfabrik\KfMobileDe\Domain\Model\Features();

        $featuresRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $featuresRepository->expects(self::once())->method('remove')->with($features);
        $this->inject($this->subject, 'featuresRepository', $featuresRepository);

        $this->subject->deleteAction($features);
    }
}

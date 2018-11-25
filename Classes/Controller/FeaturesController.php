<?php
namespace Klickfabrik\KfMobileDe\Controller;

/***
 *
 * This file is part of the "KF - Mobile.de" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Marc Finnern <typo3@klickfabrik.net>, Klickfabrik
 *
 ***/

/**
 * FeaturesController
 */
class FeaturesController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $features = $this->featuresRepository->findAll();
        $this->view->assign('features', $features);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Features $newFeatures
     * @return void
     */
    public function createAction(\Klickfabrik\KfMobileDe\Domain\Model\Features $newFeatures)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->featuresRepository->add($newFeatures);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Features $features
     * @ignorevalidation $features
     * @return void
     */
    public function editAction(\Klickfabrik\KfMobileDe\Domain\Model\Features $features)
    {
        $this->view->assign('features', $features);
    }

    /**
     * action update
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Features $features
     * @return void
     */
    public function updateAction(\Klickfabrik\KfMobileDe\Domain\Model\Features $features)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->featuresRepository->update($features);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Features $features
     * @return void
     */
    public function deleteAction(\Klickfabrik\KfMobileDe\Domain\Model\Features $features)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->featuresRepository->remove($features);
        $this->redirect('list');
    }
}

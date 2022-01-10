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
 * SpecificsController
 */
class SpecificsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $specifics = $this->specificsRepository->findAll();
        $this->view->assign('specifics', $specifics);
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
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Specifics $newSpecifics
     * @return void
     */
    public function createAction(\Klickfabrik\KfMobileDe\Domain\Model\Specifics $newSpecifics)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->specificsRepository->add($newSpecifics);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Specifics $specifics
     * @ignorevalidation $specifics
     * @return void
     */
    public function editAction(\Klickfabrik\KfMobileDe\Domain\Model\Specifics $specifics)
    {
        $this->view->assign('specifics', $specifics);
    }

    /**
     * action update
     * 
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Specifics $specifics
     * @return void
     */
    public function updateAction(\Klickfabrik\KfMobileDe\Domain\Model\Specifics $specifics)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->specificsRepository->update($specifics);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Specifics $specifics
     * @return void
     */
    public function deleteAction(\Klickfabrik\KfMobileDe\Domain\Model\Specifics $specifics)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->specificsRepository->remove($specifics);
        $this->redirect('list');
    }
}

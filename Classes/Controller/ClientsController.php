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
 * ClientsController
 */
class ClientsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * ClientsRepository
     * 
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\ClientsRepository
     * @inject
     */
    protected $ClientsRepository = null;

    # ========================================================================================
    # Google Reviews
    # ========================================================================================
    public function placesAction()
    {

        # single clients
        $clients = $this->getCurrentClient();
        if (!empty($clients) && is_array($clients)) {
            $clients = array_shift($clients);
            $this->view->assign('google_places', $clients->getApikey());
        }
    }

    # ========================================================================================
    # System helper
    # ========================================================================================
    /**
     * @return array
     */
    private function getCurrentClient()
    {

        # single clients
        if (isset($this->settings['select']['clients']) && !empty($this->settings['select']['clients'])) {
            $clients = [];
            $uids = explode(',', $this->settings['select']['clients']);
            foreach ($uids as $uid) {
                $clients[] = $this->ClientsRepository->findByUid($uid);
            }
        } else {
            $clients = $this->ClientsRepository->findAll();
        }
        return $clients;
    }
}

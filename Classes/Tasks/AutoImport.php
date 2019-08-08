<?php

namespace Klickfabrik\KfMobileDe\Tasks;


/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistrib   ute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use \Klickfabrik\KfMobileDe\Controller\ImporterController;

class AutoImport extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

    /**
     * Persistence Manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * vehicleRepository
     *
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository
     * @inject
     */
    protected $vehicleRepository = null;

    /**
     * importerRepository
     *
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\ImporterRepository
     * @inject
     */
    protected $importerRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\ClientsRepository
     * @inject
     */
    protected $clientsRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\SellerRepository
     * @inject
     */
    protected $sellerRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\FeaturesRepository
     * @inject
     */
    protected $featuresRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\SpecificsRepository
     * @inject
     */
    protected $specificsRepository = null;


    /**
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function execute() {

        $businessLogic = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Klickfabrik\KfMobileDe\Controller\ImporterController::class);
        $res = $businessLogic->checkImportAction(true,array("import"=>1));

        $this->sendMail(print_r($res,true));

        return TRUE; //ende gut, alles gut?
    }

    private function sendMail($message="ImportCommandController::sendMail()"){
        $currentDomain = preg_replace('/www\./i', '', $_SERVER['SERVER_NAME']);

        $empfaenger = 'marc@klickfabrik.net';
        $betreff    = 'Der Betreff';
        $nachricht  = $message;
        $header     = sprintf("From: typo3@%s\r\nX-Mailer: PHP/%s", $currentDomain, phpversion());
        mail($empfaenger, $betreff, $nachricht, $header);
    }
}

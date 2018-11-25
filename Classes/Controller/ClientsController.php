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


}

<?php
namespace Klickfabrik\KfMobileDe\Domain\Model;

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
 * Class FileReference
 */
class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference {

    /**
     * We need this property so that the Extbase persistence can properly persist the object
     *
     * @var integer
     */
    protected $uidLocal;

    /**
     * @param \TYPO3\CMS\Core\Resource\ResourceInterface $originalResource
     */
    public function setOriginalResource(\TYPO3\CMS\Core\Resource\ResourceInterface $originalResource) {
        $this->originalResource = $originalResource;
        $this->uidLocal = (int)$originalResource->getUid();
    }

}


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
 * Importer
 */
class Importer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $images = null;

    /**
     * features
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Features>
     */
    protected $features = null;

    /**
     * specifics
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Klickfabrik\KfMobileDe\Domain\Model\Specifics>
     */
    protected $specifics = null;

    /**
     * import
     *
     * @var int
     */
    protected $import = 0;

    /**
     * update
     *
     * @var int
     */
    protected $update = 0;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->features = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->specifics = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the import
     *
     * @return int $import
     */
    public function getimport()
    {
        return $this->import;
    }

    /**
     * Sets the import
     *
     * @param int $import
     * @return void
     */
    public function setimport($import)
    {
        $this->import = $import;
    }

    /**
     * Returns the update
     *
     * @return int $update
     */
    public function getupdate()
    {
        return $this->update;
    }

    /**
     * Sets the update
     *
     * @param int $update
     * @return void
     */
    public function setupdate($update)
    {
        $this->update = $update;
    }
}

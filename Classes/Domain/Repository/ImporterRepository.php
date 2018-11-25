<?php
namespace Klickfabrik\KfMobileDe\Domain\Repository;

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
 * The repository for Importers
 */
class ImporterRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findAll($offset=0, $limit=0) {
        $query = $this->createQuery();
        #$query->getQuerySettings()->setRespectStoragePage(TRUE);

        // Here you enable the hidden and deleted Records
        #$query->getQuerySettings()->setIgnoreEnableFields(false);

        if(!empty($offset) && !empty($limit)){
            return $query
                ->setOffset($offset)
                ->setLimit($limit)
                ->execute();
        } else {
            return $query
                ->execute();
        }
    }

    /**
     * @param array $storageIds
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface
     */
    public function setDefaultStorage(array $storageIds){
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(TRUE);
        $querySettings->setStoragePageIds($storageIds);
        $this->setDefaultQuerySettings($querySettings);

        return $querySettings;
    }
}

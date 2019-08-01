<?php
namespace Klickfabrik\KfMobileDe\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
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
 * The repository for Vehicles
 */
class VehicleRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    private $tableKey = 'tx_kfmobilede';

    private $curCount = 0;

    private $dateTimes = ['first_registration', 'creation_date', 'modification_date'];

    private $searchFields = ['model_description', 'class', 'category', 'model', 'make'];

    /**
     * @param int $curCount
     */
    public function setcurCount(int $curCount)
    {
        $this->curCount = $curCount;
    }

    /**
     * @return int
     */
    public function getcurCount()
    {
        return $this->curCount;
    }

    /**
     * @param array $settings
     * @param array $filter
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAll($settings = ['limit' => 0, 'offset' => 0], $filter = [])
    {
        $filterAllow = [
            'vehicle' => 'uid',
            'specifics' => 'specifics',
            'features' => 'features',
            'seller' => 'seller',
            'json' => 'uid',
            'uids' => 'uid'
        ];
        $query = $this->createQuery();
        $constraints = [];
        foreach ($filterAllow as $key => $field) {
            if (isset($filter[$key]) && !empty($filter[$key])) {
                $ids = array_map('intval', is_string($filter[$key]) ? explode(',', $filter[$key]) : $filter[$key]);
                switch ($key) {
                    case 'json':
                        $table = $this->tableKey . '_domain_model_vehicle';
                        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
                        $json = $filter[$key];
                        $jsonJquery = json_decode($json, true);
                        $where = [];
                        if (isset($jsonJquery['field']) && !empty($jsonJquery['field'])) {
                            foreach ($jsonJquery['field'] as $jsonfield => $jsonvalues) {
                                foreach (explode(',', $jsonvalues) as $value) {
                                    if (!empty($value)) {
                                        #$where[] = $queryBuilder->expr()->like($jsonfield, $queryBuilder->createNamedParameter($value));
                                        $where[] = $queryBuilder->expr()->like(
                                            $jsonfield,
                                            $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($value) . '%')
                                        );
                                    }
                                }
                            }
                        }
                        // Query
                        $queryBuilder->select('uid')->from($table)->where(join(' AND ', $where));
                        // ShowAll
                        if (!isset($settings['showAll']) || isset($settings['showAll']) && $settings['showAll'] == 0) {
                            // Limit
                            if (isset($settings['limit']) && $settings['limit'] > 0) {
                                $queryBuilder->setMaxResults($settings['limit']);
                            }
                            // Offset
                            if (isset($settings['offset']) && $settings['offset'] > 0) {
                                $queryBuilder->setFirstResult($settings['offset']);
                            }
                        }
                        // Execute
                        $result = $queryBuilder->execute()->fetchAll();
                        $uids = [];
                        foreach ($result as $entry) {
                            $uids[] = array_shift($entry);
                        }
                        $query->matching($query->in($field, $uids), $query->logicalAnd($query->equals('hidden', 0), $query->equals('deleted', 0)));
                        break;
                    case 'features':
                    case 'specifics':
                    case 'seller':
                        $constraints[] =  $query->equals("{$field}.uid", $filter[$key]);
                    break;
                    default:
                        $query->matching($query->in($field, $ids), $query->logicalAnd($query->equals('hidden', 0), $query->equals('deleted', 0)));
                        break;
                }
            }
        }
        if (!isset($settings['showAll']) || isset($settings['showAll']) && $settings['showAll'] == 0) {
            if ($settings['offset'] > 0) {
                $query->setOffset($settings['offset']);
            }
            if ($settings['limit'] > 0) {
                $query->setLimit($settings['limit']);
            }
        }
        if (!empty($constraints) && count($constraints) > 0) {
            $query->matching($query->logicalAnd($constraints));
        }
        $result = $query->execute();
        $this->setcurCount($result->count());
        return $result;
    }

    /**
     * @param $key
     * @param $value
     * @param int $hidden
     * @param int $delete
     * @return mixed
     */
    public function findOneByKey($key, $value, $hidden = 1, $delete = 0)
    {
        $query = $this->createQuery();
        // Here you enable the hidden and deleted Records
        if ($hidden) {
            $query->getQuerySettings()->setIgnoreEnableFields(true);
        }
        if ($delete) {
            $query->getQuerySettings()->setIncludeDeleted(true);
        }
        $query->matching($query->equals($key, $value));
        $result = $query->execute()->getFirst();
        return $result;
    }

    /**
     * @param $field
     * @param $values
     * @return array
     */
    protected function orderByField($field, $values)
    {
        $orderings = [];
        foreach ($values as $value) {
            $orderings["{$field}={$value}"] = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
        }
        return $orderings;
    }

    /**
     * @param $settings
     * @return string
     */
    protected function getLimitOffset($settings)
    {
        $return = '';
        if ($settings['showAll'] == 1) {
            $settings['limit'] = 0;
        }
        if ($settings['limit'] != '') {
            $return .= "LIMIT {$settings['limit']} ";
        }
        if ($settings['offset'] != '') {
            $return .= ", {$settings['offset']} ";
        }
        return $return;
    }

    /**
     * @param string $condition
     * @return string
     */
    private function getDefaults($condition = 'AND')
    {
        $defaults = [
            'deleted' => 0,
            'hidden' => 0
        ];
        $return = '';
        foreach ($defaults as $key => $value) {
            $return .= " {$condition} `{$key}` = {$value}";
        }
        return $return;
    }

    /**
     * @param array $storageIds
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface
     */
    public function setDefaultStorage(array $storageIds)
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(TRUE);
        $querySettings->setStoragePageIds($storageIds);
        $this->setDefaultQuerySettings($querySettings);
        return $querySettings;
    }

    /**
     * @param $request
     * @param array $options
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array
     */
    public function getSearchResults($request, $options = [])
    {
        $options = array_map('intval', $options);
        if (empty($options['limit'])) {
            $options['limit'] = 15;
        }
        $results = [];
        $constraints = [];
        $setOrderings = [];
        $query = $this->createQuery();
        foreach ($request as $requestKey => $requestValue) {
            if (!empty($requestValue)) {
                if (!is_array($requestValue)) {
                    switch ($requestKey) {
                        case 'features':
                        case 'specifics':
                            $constraints[] = $query->equals("{$requestKey}.uid", $requestValue);
                            break;
                        case 'sorting':
                            $setOrder = explode(';', $requestValue);
                            if (count($setOrder) == 2) {
                                $sort = $setOrder[1] == 'desc' ? QueryInterface::ORDER_DESCENDING : QueryInterface::ORDER_ASCENDING;
                                $setOrderings = [
                                    $setOrder[0] => $sort
                                ];
                            }
                            break;
                        case 'fulltext':
                        case 'freitext':
                            $_search = [];
                            foreach ($this->searchFields as $field) {
                                $_search[] = $query->like($field, '%' . $requestValue . '%', false);
                            }
                            $constraints[] = $query->logicalOr($_search);
                            break;
                        default:
                            $constraints[] = $query->equals($requestKey, $requestValue);
                            break;
                    }
                } else {
                    $subQuery = [];
                    switch ($requestKey) {
                        case 'first_registration':
                        case 'mileage':
                        case 'price':
                            foreach ($requestValue as $subKey => $subValue) {
                                if (!empty($subValue)) {
                                    if (in_array($requestKey, $this->dateTimes)) {
                                        switch ($subKey) {
                                            case 'min':
                                                $day = '01-01 00:00:00';
                                                break;
                                            case 'max':
                                                $day = '12-31 23:59:59';
                                                break;
                                        }
                                        $subValue = date('Y-m-d H:i:s', strtotime("{$subValue}-{$day}"));
                                    } else {
                                        $subValue = intval($subValue);
                                    }
                                    switch ($subKey) {
                                        case 'min':
                                            $subQuery[] = $query->logicalOr([
                                                $query->equals($requestKey, null),
                                                $query->greaterThanOrEqual($requestKey, $subValue)
                                            ]);
                                            break;
                                        case 'max':
                                            $subQuery[] = $query->logicalOr([
                                                $query->equals($requestKey, null),
                                                $query->lessThanOrEqual($requestKey, $subValue)
                                            ]);
                                            break;
                                    }
                                }
                            }
                            break;
                        case 'features':
                        case 'specifics':
                            $maching = [];
                            foreach ($requestValue as $value) {
                                $maching[] = $query->contains($requestKey, $value);
                            }
                            if (!empty($maching)) {
                                $subQuery[] = $query->logicalAnd($maching);
                            }
                            break;
                        case 'sorting':
                            break;
                    }
                    if (!empty($subQuery)) {
                        $constraints[] = $query->logicalAnd($subQuery);
                    }
                }
            }
        }
        $constraints[] = $query->equals('hidden', 0);
        $constraints[] = $query->equals('deleted', 0);
        $query->matching($query->logicalAnd($constraints));
        if (!empty($setOrderings)) {
            $query->setOrderings($setOrderings);
        }
        // Full Limits
        $allCount = $query->execute()->count();
        $results['limits'] = [
            'max' => $allCount,
            'offsets' => ceil($allCount / $options['limit']),
            'next_offset' => $options['offset'] + 1
        ];
        // searchbox
        if ($options['objects'] == false) {
            $subQuery = $query;
            $subResult = $subQuery->execute();
            $results['form'] = $this->collectFilterData($subResult);
            unset($subQuery);
            unset($subResult);
        }
        // Limits
        if (isset($options['offset']) && $options['offset'] > 0) {
            $query->setOffset($options['offset'] * $options['limit']);
        }
        if (isset($options['limit']) && $options['limit'] > 0) {
            $query->setLimit($options['limit']);
        }
        // Debug
        $this->debugQuery($query, $request);
        // Callbacks
        if (isset($options['objects']) && $options['objects']) {
            $results['data'] = $query->execute();
        }
        $results['count'] = $allCount;
        return $results;
    }

    /**
     * @param $subResult
     * @return array
     */
    private function collectFilterData($subResult)
    {
        $form = [];
        $allow = [
            'class', 'category', 'make', 'model',
            'fuel', 'gearbox', 'color', 'seats',
            'doors', 'power', 'emissionClass',
            'consumerPriceAmount',
            'features' => ['id'],
            'specifics' => ['id']
        ];
        foreach ($subResult as $pos => $vehicle) {
            foreach ($allow as $allowKey => $allowValue) {
                $name = is_array($allowValue) ? $allowKey : $allowValue;
                $func = 'get' . ucfirst($name);
                $data = $vehicle->{$func}();
                if (is_string($allowValue)) {
                    if (!empty($data) && (!isset($form[$name]) || !in_array($data, $form[$name]))) {
                        $form[$name][] = $data;
                    }
                } else {
                    foreach ($data as $refItem) {
                        $subData = $refItem->getUid();
                        if (!empty($subData) && (!isset($form[$name]) || !in_array($subData, $form[$name]))) {
                            $form[$name][] = $subData;
                        }
                    }
                }
            }
        }
        return $form;
    }

    # ========================================================================================
    # Searchbox
    # ========================================================================================
    /**
     * @param array $fields
     * @return array
     */
    public function getSearchBoxData(array $fields)
    {
        $constraints = [];
        $select = [];
        $where = 'WHERE hidden != 1 and deleted != 1';
        foreach ($fields as $name) {
            $select[] = "GROUP_CONCAT(DISTINCT({$name}) ORDER BY {$name} SEPARATOR ';') as {$name}";
        }
        $select = join(', ', $select);
        $query = $this->createQuery();
        $statement = "SELECT {$select} FROM {$this->tableKey}_domain_model_vehicle {$where}";
        $constraints[] = $query->statement($statement, []);
        $constraints[] = $query->equals('hidden', 0);
        $constraints[] = $query->equals('deleted', 0);
        $constraints[] = $query->setLimit(1);
        if (!empty($constraints) && count($constraints) > 1) {
            $query->matching($constraints);
        }
        // Debug
        $this->debugQuery($query);
        $results = $query->execute();
        $data = [];
        $delimiter = ';';
        foreach ($results as $result) {
            foreach ($fields as $name) {
                $call = 'get' . ucfirst($name);
                $data[$name] = array_filter(explode($delimiter, $result->{$call}()));
                natsort($data[$name]);
            }
        }
        return $data;
    }

    /**
     * @param array $fields
     * @return array
     */
    public function getSearchboxByMake(array $fields)
    {
        $return = [];
        $query = $this->createQuery();
        $where = 'WHERE hidden != 1 and deleted != 1 GROUP BY make';
        foreach ($fields as $name) {
            $select[] = "GROUP_CONCAT(DISTINCT({$name}) ORDER BY {$name} SEPARATOR ';') as {$name}";
        }
        $select = join(', ', $select);
        $statement = "SELECT {$select} FROM {$this->tableKey}_domain_model_vehicle {$where}";
        $query->statement($statement);
        ### returnRawQueryResult:TRUE (default:false)
        $results = $query->execute(TRUE);
        $delimiter = ';';
        foreach ($results as $pos => $result) {
            $make = $result['make'];
            foreach ($result as $field => $data) {
                $return[$make][$field] = array_filter(explode($delimiter, $data));
            }
            natsort($return[$make][$field]);
        }
        return $return;
    }

    /**
     * @param $name
     * @param $order
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return \DateTime|int
     */
    public function getByDate($name, $order)
    {
        $timestamp = new \DateTime('now');
        $timestamp = $timestamp->getTimestamp();
        $query = $this->createQuery();
        $date = new \DateTime('1970');
        $query->matching($query->greaterThanOrEqual($name, $date->format('Y-m-d')));
        $query->setOrderings([$name => $order == 'desc' ? QueryInterface::ORDER_DESCENDING : QueryInterface::ORDER_ASCENDING]);
        $result = $query->execute()->getFirst();
        if (!empty($result)) {
            $field = "get{$name}";
            $timestamp = $result->{$field}()->getTimestamp();
        }
        return $timestamp;
    }

    /**
     * @param $query
     * @param array $request
     */
    private function debugQuery($query, $request = [])
    {
        if (isset($_GET['debug']) && $_GET['debug'] == 1) {
            $queryParser = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser::class);
            $sqlStatement = $queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL();
            if (!empty($request)) {
                DebuggerUtility::var_dump($request);
            }
            if (!empty($sqlStatement)) {
                DebuggerUtility::var_dump($sqlStatement);
            }
            echo "<div style='max-width: 600px;height: auto'>{$sqlStatement}</div>";
        }
    }
}

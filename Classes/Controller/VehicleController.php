<?php
namespace Klickfabrik\KfMobileDe\Controller;

use InvalidArgumentException;
use Klickfabrik\KfMobileDe\Domain\Model\Vehicle;
use Klickfabrik\KfMobileDe\Domain\Repository\ClientsRepository;
use Klickfabrik\KfMobileDe\Domain\Repository\FeaturesRepository;
use Klickfabrik\KfMobileDe\Domain\Repository\SellerRepository;
use Klickfabrik\KfMobileDe\Domain\Repository\SpecificsRepository;
use Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
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
 * VehicleController
 */
class VehicleController extends ActionController
{
    /**
     * vehicleRepository
     *
     * @var VehicleRepository
     * @inject
     */
    protected $vehicleRepository = null;

    /**
     * @var SellerRepository
     * @inject
     */
    protected $sellerRepository = null;

    /**
     * @var SpecificsRepository
     * @inject
     */
    protected $specificsRepository = null;

    /**
     * @var FeaturesRepository
     * @inject
     */
    protected $featuresRepository = null;

    /**
     * @var ClientsRepository
     * @inject
     */
    protected $clientsRepository = null;

    /**
     * @var ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager = null;

    /**
     * The current request.
     *
     * @var Request
     * @api
     */
    protected $request = null;

    /**
     * @var array
     */
    protected $settings = [];

    protected $options = [
        'mileage' => 'KM Stand',
        'power' => 'PS/KW',
        'fuel' => 'Kraftstoff',
        'importKey' => 'Fahrzeugnummer',
        'gearbox' => 'Getriebe',
        'category' => 'Karosserie',
        'seller' => 'Standort',
        'first_registration' => 'Erstzulassung'
    ];

    protected $kwInPS = 1.36;

    private $goback = 'goback';

    private $specificsAllow = ['Gebrauchtfahrzeug', 'Tageszulassung', 'Elektro', 'Neufahrzeug', 'Vorführfahrzeug', 'Jahreswagen'];

    /**
     * @throws InvalidArgumentException
     * @throws InvalidQueryException
     */
    public function listAction()
    {
        $settings = $this->getSettings();
        #Debug
        if (isset($this->settings['debug']) && $this->settings['debug']) {
            $this->showArray($this->settings);
            $this->showArray($settings['filter']);
        }
        if (isset($settings['filter']['uids']) && empty($settings['filter']['uids'])) {
            $this->view->assign('vehicles', ['data' => []]);
        } else {
            $vehicles = $this->vehicleRepository->findAll($settings, $settings['filter']);
            $energy_efficiency = [];
            foreach ($vehicles as $vehicle) {
                $importKey = $vehicle->getImportKey();
                $energy_efficiency[$importKey] = $this->getEfficiency($vehicle);
            }
            $data = [
                'data' => $vehicles,
                'options' => $this->collectData($vehicles, 'options'),
                'specifics' => $this->collectData($vehicles, 'specifics'),
                'features' => $this->collectData($vehicles, 'features'),
                'seller' => $this->collectData($vehicles, 'seller'),
                'energy_efficiency' => $energy_efficiency
            ];
            $this->view->assign('vehicles', $data);
        }
        // Misc
        $this->view->assign('misc', [
            'layout' => 'list',
            'kw' => $this->kwInPS
        ]);
    }

    /**
     * action show
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function showAction(Vehicle $vehicle)
    {
        $this->settings['layout'] = 'detail';
        $data = [
            'data' => $vehicle,
            'options' => $this->collectData([$vehicle], 'options')
        ];
        $this->view->assign('vehicle', $data);
        $this->view->assign('goback', GeneralUtility::_GP($this->goback));
        // Google Maps
        $settings_map = $this->settings[$this->settings['layout']]['map'];
        if (!$settings_map['hide']) {
            if (isset($settings_map['all_places']) && $settings_map['all_places']) {
                $googleType = 'all';
                $curSellers = $this->sellerRepository->findAll();
            } else {
                $googleType = 'single';
                $curSellers = $vehicle->getSeller();
            }
            $seller = new SellerController();
            $data = $seller->getGoogleMaps($curSellers);
            $this->view->assign('google_data', json_encode($data['googleData']));
            $this->view->assign('google_type', $googleType);
            $this->view->assign('google_count', $data['count']);
            $this->view->assign('google_id', 'map_' . rand(0, 9999));
            $this->view->assign('google_places', $this->getPlacesId($vehicle->getImportClient()));
        }
        // CO2
        $this->view->assign('energy_efficiency', $this->getEfficiency($vehicle));
        // Misc
        $this->view->assign('misc', [
            'layout' => 'detail',
            'kw' => $this->kwInPS
        ]);
    }

    /**
     * @param Vehicle $vehicle
     * @return array|bool
     */
    private function getEfficiency(Vehicle $vehicle)
    {
        $data = [
            'emissionClass' => '-',
            'emissionSticker' => '',
            'emissionConsumption' => [
                'emission-sticker' => '',
                'co2-emission' => '-',
                'inner' => '-',
                'outer' => '-',
                'combined' => '-',
                'energy-efficiency-class' => ''
            ]
        ];
        if ($vehicle->getEmissionClass()) {
            $data = json_decode($vehicle->getMisc(), true);
        }
        $return = $this->array_flatten($data);
        if ($this->isJson($return['energy-efficiency-class'])) {
            $return['energy-efficiency-class'] = '';
        }
        $return['sticker_img'] = $this->get_numerics($return['emission-sticker']);
        return $return;
    }

    /**
     * @param $clientID
     * @return string
     */
    private function getPlacesId($clientID)
    {
        $clientData = $this->clientsRepository->findById($clientID);
        $apiKey = '';
        foreach ($clientData as $client) {
            $apiKey = $client->getApikey();
            if (!empty($apiKey)) {
                break;
            }
        }
        return $apiKey;
    }

    # ========================================================================================
    # Searchbox
    # ========================================================================================
    /**
     * @throws InvalidQueryException
     */
    public function searchAction()
    {
        $this->settings['layout'] = 'search';
        $settings = $this->settings[$this->settings['layout']];
        $data = [
            'translate' => $settings,
            'extensionName' => 'tx_' . strtolower($this->extensionName) . '_kfmobileview[search]',
            'kw' => $this->kwInPS
        ];
        foreach ($settings['data'] as $area => $setting_data) {
            if (!empty($setting_data)) {
                $data['data'][$area] = $this->vehicleRepository->getSearchBoxData(array_keys($setting_data));
            }
        }
        // Searchbox with json-Data
        $data['data']['json'] = json_encode($this->vehicleRepository->getSearchboxByMake(array_keys($setting_data)));
        // Ranges
        $data['data']['select']['range'] = [
            'range' => $this->getSearchboxRange(0, 150000, 10000),
            'year' => $this->getSearchboxRange(date('Y'), date('Y', $this->vehicleRepository->getByDate('firstRegistration', 'asc')), 1),
            'price' => $this->getSearchboxRange(1000, 100000, 1000)
        ];
        // Reps
        $data['data']['select']['seller'] = $this->sellerRepository->findAll();
        $data['data']['select']['specifics'] = $this->specificsRepository->findAll();
        $data['data']['select']['features'] = $this->featuresRepository->findAll();
        // ReOrder
        foreach ($data['data']['select'] as $key => $rep) {
            switch ($key) {
                case 'class':
                    $tmp = [];
                    foreach ($rep as $pos => $value){
                        $first = explode(" ",$value);
                        $firstKey = strtolower(array_shift($first));
                        $tmp[$firstKey] = $value;
                    }
                    $data['data']['select'][$key] = $tmp;
                    break;
                case 'specifics':
                    $count = count($rep);
                    for ($i = 0; $i < $count; $i++) {
                        $curRep = $rep[$i];
                        $desc = $curRep->getDescription();
                        $allow = "{$key}Allow";
                        if (!in_array($desc, $this->{$allow})) {
                            unset($data['data']['select']['specifics'][$i]);
                        }
                    }
                    break;
            }
        }
        foreach ($settings['tabs'] as $area => $tabData) {
            $data['tabs'][$area] = $tabData;
            $data['tabs'][$area]['fields'] = explode(',', $tabData['fields']);
        }
        $this->view->assign('vehicle', $data);
        $this->view->assign('goback', $GLOBALS['TSFE']->id);
        // Misc
        $this->view->assign('misc', [
            'layout' => 'search',
            'kw' => $this->kwInPS
        ]);
    }

    # ========================================================================================
    # Ajax Requests
    # ========================================================================================
    /**
     * @throws InvalidQueryException
     */
    public function ajaxResultAction()
    {
        $data = [];
        $searchRequest = GeneralUtility::_GP('_search');
        $objects = GeneralUtility::_GP('objects');
        if ($objects == -1) {
            $this->resetLastSearch();
            $objects = 0;
        }
        if (!is_null($searchRequest) && !empty($searchRequest)) {
            $data['result'] = $this->vehicleRepository->getSearchResults($searchRequest, [
                'objects' => $objects,
                'limit' => GeneralUtility::_GP('limit'),
                'offset' => GeneralUtility::_GP('offset')
            ]);
            $data['result']['goback'] = GeneralUtility::_GP($this->goback);
        }
        $this->saveLastSearch($searchRequest);
        if ($objects == false) {
            return json_encode($data['result']);
        }
        foreach ($data['result'] as $pos => $vehicles) {
            if (is_object($vehicles)) {
                foreach ($vehicles as $vehicle) {
                    $data['result']['energy_efficiency'][$vehicle->getImportKey()] = $this->getEfficiency($vehicle);
                }
            }
        }
        $this->view->assign('vehicles', $data['result']);
        // Misc
        $this->view->assign('misc', [
            'layout' => 'ajaxResult',
            'kw' => $this->kwInPS
        ]);
    }

    /**
     * @param $searchRequest
     */
    private function saveLastSearch($searchRequest)
    {
        $this->setCookieData('search', $searchRequest);
    }

    private function resetLastSearch()
    {
        $this->setCookieData('search', '');
    }

    # ========================================================================================
    # Helper functions
    # ========================================================================================
    /**
     * @param $string
     * @return bool
     */
    function isJson($string)
    {
        if (is_string($string)) {
            json_decode($string);
            return json_last_error() == JSON_ERROR_NONE;
        } else {
            return false;
        }
    }

    /**
     * @param $str
     * @return mixed
     */
    function get_numerics($str)
    {
        preg_match_all('/\\d+/', $str, $matches);
        return is_array($matches[0]) ? array_shift($matches[0]) : $matches[0];
    }

    /**
     * @param $array
     * @return array|bool
     */
    function array_flatten($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * @param $vehicles
     * @param $type
     * @return array
     */
    private function collectData($vehicles, $type)
    {
        $result = [];
        $layout = $this->settings['layout'];
        $options = isset($this->settings[$layout][$type]) ? $this->settings[$layout][$type] : $this->{$type};
        if ($options['use']) {
            foreach ($vehicles as $vehicle) {
                $importKey = $vehicle->getImportKey();
                foreach ($options as $field => $translate) {
                    $call = 'get' . ucfirst($field);
                    if (method_exists($vehicle, $call)) {
                        $object = $vehicle->{$call}();
                        $data = !is_array($object) ? is_null($object) ? 0 : $object : $object;
                        $result[$importKey][$translate] = $data;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    private function getSettings()
    {
        $ov = $this->settings['overwrite'];
        // Typoscript
        $limit = isset($this->settings['list']['items']) && $this->settings['list']['items'] != '' ? $this->settings['list']['items'] : 10;
        $offset = isset($_GET['page']) && $_GET['page'] > 0 ? ($_GET['page'] - 1) * $limit : 0;
        $filter = isset($this->settings['select']) ? $this->settings['select'] : [];
        $showAll = isset($this->settings['list']['showAll']) && $this->settings['list']['showAll'] != '' ? $this->settings['list']['showAll'] : 0;
        // overwrite
        $limit = isset($ov['list']['items']) && $ov['list']['items'] != '' ? $ov['list']['items'] : $limit;
        $offset = isset($_GET["{$this->extensionName}[page]"]) && !empty($_GET["{$this->extensionName}[page]"]) ? $_GET["{$this->extensionName}[page]"] : $offset;
        $showAll = isset($ov['list']['showAll']) && $ov['list']['showAll'] != '' ? $ov['list']['showAll'] : $showAll;
        // Cookie
        if (isset($this->settings['list']['cookies']) && $this->settings['list']['cookies'] == 1) {
            $filter['mode'] = 'cookie';
            $filter['uids'] = $this->getCookieData();
        }
        if (isset($filter['uids']) && !empty($filter['uids'])) {
            $filter['mode'] = 'uids';
        }
        if (!isset($filter['mode'])) {
            $filter['mode'] = 'default';
        }
        return [
            'limit' => intval($limit),
            'offset' => intval($offset),
            'filter' => $filter,
            'showAll' => $showAll
        ];
    }

    /**
     * @param $start
     * @param $end
     * @param $steps
     * @return array
     */
    private function getSearchboxRange($start, $end, $steps)
    {
        return range($start, $end, $steps);
    }

    /**
     * @param string $cookieName
     * @return array
     */
    private function getCookieData($cookieName = 'kf_mobile_de')
    {
        $uids = [];
        $data = $_COOKIE[$cookieName];
        if (!empty($data)) {
            $uids = explode('|', $data);
        }
        return array_filter($uids);
    }

    /**
     * @param $cookieName
     * @param $cookieData
     * @param $ttl
     */
    private function setCookieData($cookieName, $cookieData, $ttl = 0)
    {
        $cookieName = $this->extensionName . $cookieName;
        if (is_array($cookieData)) {
            $cookieData = json_decode(json_encode($cookieData), true);
            $cookieData = json_encode($cookieData);
            $cookieData = stripslashes($cookieData);
        }
        setcookie($cookieName, $cookieData, $ttl);
    }

    # ========================================================================================
    # In Arbeit
    # ========================================================================================
    /**
     * @param $arr
     */
    public function showArray($arr)
    {
        echo '<pre>' . print_r($arr, true) . '</pre>';
    }

    /**
     * @param $arr
     */
    public function showDebug($arr)
    {
        /** \TYPO3\CMS\Extbase\Utility\DebuggerUtility */
        DebuggerUtility::var_dump($arr);
    }

    # ========================================================================================
    # Ungebraucht
    # ========================================================================================
    /**
     * @return array
     */
    private function getPager()
    {
        $settings = $this->getSettings();
        $limit = $settings['limit'];
        $all = $this->vehicleRepository->getcurCount();
        $pages = ceil($all / $limit);
        $return = [
            'limit' => $limit,
            'all' => $all,
            'pages' => $pages,
            'active' => $pages > 1
        ];
        return $return;
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
     * @param Vehicle $newVehicle
     * @return void
     */
    public function createAction(Vehicle $newVehicle)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', AbstractMessage::WARNING);
        $this->vehicleRepository->add($newVehicle);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param Vehicle $vehicle
     * @ignorevalidation $vehicle
     * @return void
     */
    public function editAction(Vehicle $vehicle)
    {
        $this->view->assign('vehicle', $vehicle);
    }

    /**
     * action update
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function updateAction(Vehicle $vehicle)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', AbstractMessage::WARNING);
        $this->vehicleRepository->update($vehicle);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function deleteAction(Vehicle $vehicle)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', AbstractMessage::WARNING);
        $this->vehicleRepository->remove($vehicle);
        $this->redirect('list');
    }
}

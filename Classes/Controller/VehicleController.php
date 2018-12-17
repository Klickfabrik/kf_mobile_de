<?php
namespace Klickfabrik\KfMobileDe\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
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
class VehicleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * vehicleRepository
     *
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository
     * @inject
     */
    protected $vehicleRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\SellerRepository
     * @inject
     */
    protected $sellerRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\SpecificsRepository
     * @inject
     */
    protected $specificsRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\FeaturesRepository
     * @inject
     */
    protected $featuresRepository = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\ClientsRepository
     * @inject
     */
    protected $clientsRepository = null;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager = null;

    /**
     * The current request.
     *
     * @var \TYPO3\CMS\Extbase\Mvc\Request
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
        'importKey' => 'Fahrzeug-ID',
        'gearbox' => 'Getriebe',
        'category' => 'Karosserie',
        'seller' => 'Standort'
    ];

    protected $kw = 0.735499;

    private $goback = 'goback';

    /**
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function listAction()
    {
        #Debug
        if (isset($this->settings['debug']) && $this->settings['debug']) {
            $this->showArray($this->settings);
        }
        $settings = $this->getSettings();
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

    /**
     * action show
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle
     * @return void
     */
    public function showAction(\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle)
    {
        $this->settings['layout'] = 'detail';
        $data = [
            'data' => $vehicle,
            'options' => $this->collectData([$vehicle], 'options')
        ];
        $this->view->assign('vehicle', $data);
        $this->view->assign('goback', GeneralUtility::_GP($this->goback));
        // Google Maps
        $seller = new SellerController();
        $data = $seller->getGoogleMaps($vehicle->getSeller());
        $this->view->assign('google_data', json_encode($data['googleData']));
        $this->view->assign('google_id', 'map_' . rand(0, 9999));
        $this->view->assign('google_places', $this->getPlacesId($vehicle->getImportClient()));
        // CO2
        $this->view->assign('energy_efficiency', $this->getEfficiency($vehicle));
    }

    /**
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle
     * @return array|bool
     */
    private function getEfficiency(\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle)
    {
        $data = [
            'emissionClass' => '-',
            'emissionSticker' => '',
            'emissionConsumption' => [
                'emission-sticker' => '',
                'co2-emission' => '-',
                'inner' => '-',
                'outer' => '-',
                'combined' => '-'
            ]
        ];
        if ($vehicle->getEmissionClass()) {
            $data = json_decode($vehicle->getMisc(), true);
        }
        $return = $this->array_flatten($data);
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
     * action search
     *
     * @return void
     */
    public function searchAction()
    {
        $this->settings['layout'] = 'search';
        $settings = $this->settings[$this->settings['layout']];
        $data = [
            'translate' => $settings,
            'extensionName' => 'tx_' . strtolower($this->extensionName) . '_kfmobileview[search]',
            'kw' => $this->kw
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
            'year' => $this->getSearchboxRange(date('Y'), date('Y') - 30, 1),
            'price' => $this->getSearchboxRange(1000, 100000, 1000)
        ];
        // Reps
        $data['data']['select']['seller'] = $this->sellerRepository->findAll();
        $data['data']['select']['specifics'] = $this->specificsRepository->findAll();
        $data['data']['select']['features'] = $this->featuresRepository->findAll();
        // ReOrder
        foreach ($data['data']['select'] as $key => $rep) {
            switch ($key) {
                case 'specifics':
                    $allow = ['Gebrauchtfahrzeug', 'Tageszulassung', 'Elektro', 'Neufahrzeug', 'Vorführfahrzeug', 'Jahreswagen'];
                    $count = count($rep);
                    for ($i = 0; $i < $count; $i++) {
                        $curRep = $rep[$i];
                        $desc = $curRep->getDescription();
                        if (!in_array($desc, $allow)) {
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
    }

    # ========================================================================================
    # Ajax Requests
    # ========================================================================================


    /**
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function ajaxResultAction()
    {
        $data = [];
        $searchRequest = GeneralUtility::_GP('_search');
        if (!is_null($searchRequest) && !empty($searchRequest)) {
            $data['result'] = $this->vehicleRepository->getSearchResults($searchRequest, [
                'objects' => GeneralUtility::_GP('objects'),
                'limit' => GeneralUtility::_GP('limit'),
                'offset' => GeneralUtility::_GP('offset')
            ]);

            $data['result']['goback'] = GeneralUtility::_GP($this->goback);
        }
        $this->saveLastSearch($searchRequest);
        if (GeneralUtility::_GP('objects') == false) {
            return json_encode($data['result']);
        }

        foreach ($data['result'] as $pos => $vehicles){
            if(is_object($vehicles)){
                foreach ($vehicles as $vehicle){
                    $data['result']['energy_efficiency'][$vehicle->getImportKey()] = $this->getEfficiency($vehicle);
                }
            }
        }


        $this->view->assign('vehicles', $data['result']);
    }

    /**
     * @param $searchRequest
     */
    private function saveLastSearch($searchRequest)
    {
        $this->setCookieData('search', $searchRequest);
    }

    # ========================================================================================
    # Helper functions
    # ========================================================================================


    /**
     * @param $str
     */
    function get_numerics($str)
    {
        preg_match_all('/\\d+/', $str, $matches);
        return is_array($matches[0]) ? array_shift($matches[0]) : $matches[0];
    }

    /**
     * @param $array
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
            $filter['uids'] = $this->getCookieData();
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
        return $uids;
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
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($arr);
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
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Vehicle $newVehicle
     * @return void
     */
    public function createAction(\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $newVehicle)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->vehicleRepository->add($newVehicle);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle
     * @ignorevalidation $vehicle
     * @return void
     */
    public function editAction(\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle)
    {
        $this->view->assign('vehicle', $vehicle);
    }

    /**
     * action update
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle
     * @return void
     */
    public function updateAction(\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->vehicleRepository->update($vehicle);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle
     * @return void
     */
    public function deleteAction(\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $vehicle)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->vehicleRepository->remove($vehicle);
        $this->redirect('list');
    }
}
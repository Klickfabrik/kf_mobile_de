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
 * ImporterController
 */
class ImporterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    private $tmpDir         = PATH_site . "typo3temp/";
    private $tmpImageDir    = PATH_site . "fileadmin/user_upload/_temp_/";
    private $uploadFolder   = "user_upload/kf_mobile/";
    private $pageSize       = 50;
    private $checks         = array();
    private $mobileGetter   = null;
    private $debug          = 0;
    private $force_update   = 0;
    private $singleList     = array();
    private $mode           = "single";
    private $pid            = null;

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
     * @var \Klickfabrik\KfMobileDe\Helper\Dom2Array
     * @inject
     */
    protected $Dom2Array = null;

    /**
     * @var \Klickfabrik\KfMobileDe\Helper\Ads2Value
     * @inject
     */
    protected $Ads2Value = null;




    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $this->redirect('checkImport');

        $importers = $this->importerRepository->findAll();
        $this->view->assign('importers', $importers);

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
    public function createVehicleAction(\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $newVehicle)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->vehicleRepository->add($newVehicle);
        $this->redirect('list');
    }


    /**
     * @param bool $return
     * @param array $args
     * @return array
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    public function checkImportAction($return=false, $args=array()){
        $status = array(
            'count'     => 0,
            'clients'   => array(),
            'args'      => $args
        );

        // create defaultimage-folder
        $this->createDefaultFolder();

        $args = empty($args) ? $this->request->getArguments() : $args;

        $clients = $this->clientsRepository->findAll();
        $clientsArray = $clients->toArray();

        // download data
        if($clientsArray){
            $status['clients']  = $clientsArray;
            $status['count']    = count($clientsArray);

            foreach ($clientsArray as $pos => $client){
                $status['clients'][$pos] = array(
                    "name"  => $client->getName(),
                    "id"    => $client->getId(),
                );

                // inital Getter
                $config = array(
                    "username" => $client->getUsername(),
                    "password" => $client->getPassword(),
                );
                $this->mobileGetter = new \Klickfabrik\KfMobileDe\Helper\MobileGetter($config);

                /**
                 * Status all elements
                 */
                if(isset($args['status']) && $args['status'] == 1){
                    $status['clients'][$pos]['count'] = self::getSellerCount($this->mobileGetter);
                }

                /**
                 * Update new elements
                 * Force update all items
                 */
                if(
                    isset($args['update']) && $args['update'] == 1 ||
                    isset($args['update_force']) && $args['update_force'] == 1
                ){
                    $filename = "{$client->getId()}.xml";
                    if(isset($args['update_force']) && $args['update_force'] == 1){
                        $this->force_update = 1;
                    }

                    if($this->mode == "single"){


                        self::createSingleCalls($this->tmpDir . $filename);
                        foreach ($this->singleList[$filename] as $singleFile){
                            $file = $singleFile['file'];

                            $status['seller'][]     = self::createSeller($file);
                            $status['features'][]   = self::createTags($file, "name", "features");
                            $status['specifics'][]  = self::createTags($file, "name", "specifics");
                            $status['vehicles'][]   = self::createVehicles($file);

                        }
                    } else {
                        $file = $this->tmpDir . $filename;

                        $status['seller'][]     = self::createSeller($file);
                        $status['features'][]   = self::createTags($file, "name", "features");
                        $status['specifics'][]  = self::createTags($file, "name", "specifics");
                        $status['vehicles'][]   = self::createVehicles($file);
                    }
                }

                /**
                 * Debugmodus
                 */
                if(isset($args['test']) && $args['test'] == 1){


                    /*
                    $filename = "{$client->getId()}.xml";

                    if($this->mode == "single"){
                        $this->force_update = 1;

                        self::createSingleCalls($this->tmpDir . $filename);
                        foreach ($this->singleList[$filename] as $singleFile){
                            $file = $singleFile['file'];

                            $status['seller'][]     = self::createSeller($file);
                            $status['features'][]   = self::createTags($file, "name", "features");
                            $status['specifics'][]  = self::createTags($file, "name", "specifics");
                            $status['vehicles'][]   = self::createVehicles($file);

                        }
                    } else {
                        $file = $this->tmpDir . $filename;

                        $status['seller'][]     = self::createSeller($file);
                        $status['features'][]   = self::createTags($file, "name", "features");
                        $status['specifics'][]  = self::createTags($file, "name", "specifics");
                        $status['vehicles'][]   = self::createVehicles($file);
                    }
                    */
                }


                // inital Import
                if(isset($args['import']) && $args['import'] == 1){
                    $filename = "{$client->getId()}.xml";
                    self::unlinkUploadTmpFile($filename);

                    $status['clients'][$pos]['download'] = self::downloadXML($this->mobileGetter,$client);
                }
            }

            self::checkInvalideData();
        }

        if($return){
            return $status;
        } else {
            $this->view->assign('importers', $status);
        }
    }


    /**
     * @param $filename
     * @param string $search
     * @param string $repKey
     * @return array
     */
    private function createTags($filename, $search="name", $repKey="specifics"){

        $status  = array(
            "type"  => "createTags",
            "mode"  => $this->mode,
            "rep"   => $repKey,
            "count" => 0,
        );

        if(file_exists($filename)) {
            $xml = new \DOMDocument();
            $xml->load($filename);

            $xmlArray = \Klickfabrik\KfMobileDe\Helper\Dom2Array::xml_to_array($xml);

            # XML Parsing
            $xml = new \Klickfabrik\KfMobileDe\Helper\Ads2Value();
            $xml->setXml($xmlArray);

            // $rep
            $getFunc= "get" . ucfirst($repKey);
            $rep    = $repKey . "Repository";

            $tags = $xml->$getFunc($this->mode);
            foreach ($tags['all'] as $tag){
                if(!empty($tag['key'])){
                    $status['count']++;

                    $name = $tag['key'];
                    $desc = $tag['value'];

                    // Prüfen ob die Daten schon vorhanden sind
                    $find   = "findOneBy" . ucfirst($search);
                    $check  = $this->$rep->$find($name);

                    // Update Status
                    $new = empty($check);
                    if($new){
                        switch($repKey){
                            case "features":
                                $model = new \Klickfabrik\KfMobileDe\Domain\Model\Features();
                                break;
                            case "specifics":
                                $model = new \Klickfabrik\KfMobileDe\Domain\Model\Specifics();
                                break;
                        }
                        $newElement     = $model;
                    } else {
                        $newElement     = $check;
                    }

                    $newElement->setName($name);
                    $newElement->setDescription($desc);

                    // Set PID für Taskmanager
                    if(!is_null($this->pid))
                        $newElement->setPid($this->pid);

                    if($new){
                        $this->$rep->add($newElement);
                    } else {
                        $this->$rep->update($newElement);
                    }
                }
            }

            $this->saveData();
        }

        if ($this->debug)
            return $status;
    }


    /**
     * @param $filename
     * @param string $search
     * @param string $rep
     * @return array
     */
    private function createSeller($filename, $search="importKey", $rep="sellerRepository"){
        $status  = array(
            "type"  => "createSeller",
            "mode"  => $this->mode,
            "rep"   => $rep,
            "count" => 0,
        );

        if(file_exists($filename)){
            $xml = new \DOMDocument();
            $xml->load($filename);

            $xmlArray  = \Klickfabrik\KfMobileDe\Helper\Dom2Array::xml_to_array($xml);

            # XML Parsing
            $xml = new \Klickfabrik\KfMobileDe\Helper\Ads2Value();
            $xml->setXml($xmlArray);


            # File Info
            $fileInfo   = pathinfo($filename);
            $sellerUrls = array();

            // Daten verarbeiten
            $count = $xml::getCountByTag('seller:seller','key');
            for ($i = 0; $i < $count;){
                $status['count']++;

                if($this->mode != "single")
                    $xml::setPos($i);

                // Daten sammeln
                $xmlResult = array(
                    "_url"          => $xml::getTag('','url'),

                    "importKey"     => $xml::getTag('seller:seller','key'),
                    "url"           => $xml::getTag('seller:seller','url'),
                    "zipcode"       => $xml::getTag('seller:seller|seller:address|seller:zipcode'),
                    "city"          => $xml::getTag('seller:seller|seller:address|seller:city'),
                    "countryCode"   => $xml::getTag('seller:seller|seller:address|seller:country-code'),
                    "commercial"    => $xml::getTag('seller:seller|seller:type','commercial'),
                    "latitude"      => $xml::getTag('seller:seller|seller:coordinates|seller:latitude'),
                    "longitude"     => $xml::getTag('seller:seller|seller:coordinates|seller:longitude'),
                );

                $cur = array(
                    "import"            => true,
                );

                $later = array(

                );

                foreach ($xmlResult as $name => $data){
                    $firstData  = array_shift($xmlResult[$name]['data']);
                    switch($name){
                        case substr($name,0,1) == "_":
                            $later[$name] = $firstData['value'];
                            break;
                        default:
                            $value = $firstData['value'];
                            break;
                    }

                    // false / true string to bool
                    $value = in_array($value,array("false","true")) ? filter_var($value, FILTER_VALIDATE_BOOLEAN) : $value;

                    if($value != "")
                        $cur[$name] = $value;
                }

                // Prüfen ob die Daten schon vorhanden sind
                $find   = "findOneBy" . ucfirst($search);
                $obj    = $this->$rep->$find($cur[$search]);
                $objNew = empty($obj);

                // Daten für spätere Checks
                $this->checks[$rep]['type'] = $search;
                $this->checks[$rep]['file'] = $fileInfo['filename'] . DIRECTORY_SEPARATOR . $cur['importKey'];
                $this->checks[$rep]['data'][] = $cur[$search];

                // Update Status
                if($objNew){
                    $newElement     = new \Klickfabrik\KfMobileDe\Domain\Model\Seller();
                    $sellerUrls[]   = array(
                        "url"   => $later['_url'],
                        "key"   => $cur['importKey'],
                        "obj"   => $newElement,
                    );
                } else {
                    $newElement     = $obj;
                }

                // Daten
                foreach ($cur as $key => $value){
                    switch($key){
                        case strpos(strtolower($key),"date") !== false:
                            $value = new \DateTime($value);
                            break;
                    }

                    call_user_func_array(array($newElement, 'set' . ucfirst($key) ), array($value));
                }

                // Set PID für Taskmanager
                if(!is_null($this->pid))
                    $newElement->setPid($this->pid);

                // Update & Insert
                $objNew
                    ? $this->$rep->add($newElement)
                    : $this->$rep->update($newElement);

                // Count
                $i++;
            }

            // Update Seller with more
            if(!empty($sellerUrls)){
                foreach ($sellerUrls as $seller){
                    $sellerXML  = $this->getCurlInformation($this->mobileGetter,$seller['url']);
                    self::updateSeller($seller,$sellerXML,$this->$rep);
                }
            }
            $this->saveData();

        } else {
            exit('Konnte .xml nicht öffnen.');
        }

        if ($this->debug)
            return $status;
    }


    /**
     * @param $sellerArr
     * @param $xmlData
     * @param $rep
     */
    private function updateSeller($sellerArr, $xmlData, $rep){
        $insert     = false;
        $newElement  = $rep->findOneByImportKey($sellerArr['key']);
        if(empty($newElement)){
            $insert     = true;
            $newElement  = $sellerArr['obj'];
        }

        $updateData = array(
            "companyName"   => "seller:seller|seller:company-name",
            "email"         => "seller:seller|seller:email",
            "street"        => "seller:seller|seller:address|seller:street",
            "phone"         => "seller:seller|seller:phone",
        );

        $xmlData::setPos("ad:ad");
        foreach ($updateData as $name => $data){
            $value = $xmlData::getTagValue($data);
            call_user_func_array(array($newElement, 'set' . ucfirst($name) ), array($value));
        }

        // Set PID für Taskmanager
        if(!is_null($this->pid))
            $newElement->setPid($this->pid);

        if($insert){
            $rep->add($newElement);
        } else {
            $rep->update($newElement);
        }
    }


    /**
     * @param $filename
     * @param string $search
     * @param string $rep
     * @return array
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    private function createVehicles($filename, $search="importKey", $rep="vehicleRepository"){
        $starttime = microtime(true);
        $status = array(
            "new"   => 0,
            "update"=> 0,
            "skip"  => 0,
        );

        if(file_exists($filename)){
            $xml = new \DOMDocument();
            $xml->load($filename);

            $xmlArray  = \Klickfabrik\KfMobileDe\Helper\Dom2Array::xml_to_array($xml);

            # XML Parsing
            $xml = new \Klickfabrik\KfMobileDe\Helper\Ads2Value();
            $xml->setXml($xmlArray,true,$this->mode);

            # File Info
            $fileInfo = pathinfo($filename);

            // data handler
            $count = $xml::getCount();
            for ($i = 0; $i < $count;){
                $xml::setPos($i);

                // smart check for update
                $cur = array(
                    "importKey"             => $this->getValue($xml::getTag('','key'),"importKey"),
                    "modificationDate"      => $this->getValue($xml::getTag('ad:modification-date'),"modificationDate"),
                );

                // check for data
                $find   = "findOneBy" . ucfirst($search);
                $obj    = $this->$rep->$find($cur[$search]);
                $objNew = empty($obj);

                // object
                $newElement = $objNew
                    ? new \Klickfabrik\KfMobileDe\Domain\Model\Vehicle()
                    : $obj;


                // data for later checks
                $this->checks[$rep]['type'] = $search;
                $this->checks[$rep]['file'] = $fileInfo['filename'] . DIRECTORY_SEPARATOR . $cur['importKey'];
                $this->checks[$rep]['data'][] = $cur[$search];

                // check update
                $update = true;
                if($newElement->getModificationDate() == new \DateTime($cur['modificationDate'])){
                    $status['skip']++;
                    $update = false;
                }
                if($this->force_update == 1){
                    $update = true;
                }

                if($update){
                    if($objNew){
                        $status['new']++;
                    } else {
                        $status['update']++;
                    }

                    $imageTag = $this->mode == "single" ? 'ad:images|ad:image' : 'ad:images|ad:image|ad:representation';

                    // collect data
                    $xmlResult = array(
                        'modelDescription'      => $xml::getTag('ad:vehicle|ad:model-description'),
                        'class'                 => $xml::getTag('ad:vehicle|ad:class'),
                        'description'           => $xml::getTag('ad:description','raw'),
                        'category'              => $xml::getTag('ad:vehicle|ad:category'),
                        'make'                  => $xml::getTag('ad:vehicle|ad:make'),
                        'model'                 => $xml::getTag('ad:vehicle|ad:model'),
                        'damageAndUnrepaired'   => $xml::getTag('ad:vehicle|ad:damage-and-unrepaired'),
                        'roadworthy'            => $xml::getTag('ad:vehicle|ad:roadworthy'),

                        'priceType'             => $xml::getTag('ad:price','type'),
                        'price'                 => $xml::getTag('ad:price|ad:consumer-price-amount'),
                        'dealerPriceAmount'     => $xml::getTag('ad:price|ad:dealer-price-amount'),
                        'consumerPriceAmount'   => $xml::getTag('ad:price|ad:consumer-price-amount'),

                        'importKey'             => $xml::getTag('','key'),
                        'detailPage'            => $xml::getTag('ad:detail-page','url'),
                        'modificationDate'      => $xml::getTag('ad:modification-date'),
                        'creationDate'          => $xml::getTag('ad:creation-date'),

                        // relations
                        'seller'                => $xml::getTag('seller:seller','key'),
                        'specifics'             => [
                            'fuel'          => $xml::getTag('ad:vehicle|ad:specifics|ad:fuel','key'),
                            'gearbox'       => $xml::getTag('ad:vehicle|ad:specifics|ad:gearbox','key'),
                            'emissionClass' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-class','key'),
                        ],
                        'features'              => $xml::getFeatures(),

                        // spects
                        'power'                 => $xml::getTag('ad:vehicle|ad:specifics|ad:power','key'),
                        'mileage'               => $xml::getTag('ad:vehicle|ad:specifics|ad:mileage'),
                        'seats'                 => $xml::getTag('ad:vehicle|ad:specifics|ad:num-seats'),
                        'doors'                 => $xml::getTag('ad:vehicle|ad:specifics|ad:door-count'),
                        'emissionClass'         => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-class'),
                        'firstRegistration'     => $xml::getTag('ad:vehicle|ad:specifics|ad:first-registration'),
                        'fuel'                  => $xml::getTag('ad:vehicle|ad:specifics|ad:fuel'),
                        'gearbox'               => $xml::getTag('ad:vehicle|ad:specifics|ad:gearbox'),
                        'color'                 => $xml::getTag('ad:vehicle|ad:specifics|ad:exterior-color|ad:manufacturer-color-name'),

                        // Misc
                        'misc'  => [
                            'emissionClass'         => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-class','key'),
                            'emissionSticker'       => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-sticker','key'),
                            'emissionConsumption'   => [
                                'emission-sticker' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-sticker'),
                                'envkv-compliant' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-fuel-consumption','envkv-compliant'),
                                'co2-emission' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-fuel-consumption','co2-emission'),
                                'inner' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-fuel-consumption','inner'),
                                'outer' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-fuel-consumption','outer'),
                                'combined' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-fuel-consumption','combined'),
                                'unit' => $xml::getTag('ad:vehicle|ad:specifics|ad:emission-fuel-consumption','unit'),
                            ],
                        ],

                        // Images
                        'images'                => $xml::getTag($imageTag)
                    );

                    $cur = array(
                        'import'            => true,
                        'importClient'      => $fileInfo['filename'],
                    );

                    foreach ($xmlResult as $name => $data){
                        $firstData  = $this->getValue($xmlResult,$name);
                        switch($name){
                            case "seller":
                                $find   = "findOneBy" . ucfirst($search);
                                $value  = $this->sellerRepository->$find($firstData);
                                break;
                            case "features":
                                $value = array();
                                if($data != null){
                                    foreach ($data as $relValue){
                                        $relName    = $relValue['key'];
                                        $resData    = $this->featuresRepository->findOneByName($relName);

                                        if(!empty($resData))
                                            $value[$name][] = $resData;
                                    }
                                }
                                break;
                            case "specifics":
                                $value = array();
                                if($data != null){
                                    foreach ($data as $relKey => $relValue){
                                        $relName    = $this->getValue($data,$relKey);
                                        $resData    = $this->specificsRepository->findOneByName($relName);

                                        if(!empty($resData))
                                            $value[$name][] = $resData;
                                    }
                                }
                                break;
                            case "images":
                                $json = $this->isJson($firstData);
                                if($json){
                                    $data = json_decode($firstData,true);

                                    $single = true;
                                    $value  = array();
                                    foreach ($data as $imageArray){
                                        if(isset($imageArray['ad:representation'])){
                                            $single     = false;
                                            $imageData  = $imageArray['ad:representation'];

                                            $subImages = array();
                                            foreach ($imageData as $subData){
                                                if(isset($subData['@attributes'])){
                                                    $subImages[] =  array_shift($subData);
                                                }
                                            }
                                            $value[]    = !empty($subImages) ? $subImages : $imageData;
                                        } else {
                                            $value[]    = $imageArray;
                                        }
                                    }

                                    if($single){
                                        $value = array($value);
                                    }
                                    $value = json_encode($value);
                                } else {
                                    $value = $firstData;
                                }
                                break;
                            case "misc":
                                $value = $this->parseArrayValues($data);
                                if(!empty($value) && is_array($value)){
                                    $value = json_encode($value);
                                } else {
                                    $value = "";
                                }
                                break;
                            default:
                                $value = $firstData;
                                break;
                        }

                        if($value != ""){
                            // false / true string to bool
                            $value = in_array($value,array("false","true")) ? filter_var($value, FILTER_VALIDATE_BOOLEAN) : $value;

                            $cur[$name] = $value;
                        }
                    }

                    // Daten
                    foreach ($cur as $key => $value){
                        switch($key){
                            case strpos(strtolower($key),"date") !== false:
                                $value = new \DateTime($value);
                                break;
                            case "firstRegistration":
                                $value = new \DateTime($value);
                                break;
                            case "features":
                                if($value[$key] != null){
                                    foreach ($value[$key] as $obj){
                                        $newElement->addFeature($obj);
                                    }
                                }

                                // clear
                                $value = "";
                                break;
                            case "specifics":
                                if($value[$key] != null){
                                    foreach ($value[$key] as $obj){
                                        $newElement->addSpecific($obj);
                                    }
                                }

                                // clear
                                $value = "";
                                break;
                            case "image":
                            case "images":
                                $subFolder  = ""; //$this->checks[$rep]['file'];
                                $target     = $this->uploadFolder . $subFolder . DIRECTORY_SEPARATOR;

                                $this->createDefaultFolder($subFolder);

                                // Download
                                if($this->isJson($value)){
                                    // remove old images
                                    $this->removeImages($newElement);

                                    // add new images
                                    $pos = 1;
                                    $data = json_decode($value,true);
                                    $imageData = $this->parseImageData($data);
                                    $size = "XL";

                                    foreach ($imageData as $image){
                                        if(isset($image[$size])){
                                            $imageURL = $image[$size];

                                            // File
                                            $pathinfo       = pathinfo($imageURL);
                                            $fileName       = strtolower("{$this->extensionName}_{$fileInfo['filename']}_{$pos}.{$pathinfo['extension']}");
                                            $checkFile      = PATH_site . "fileadmin/{$target}{$fileName}";

                                            // Download
                                            if(!file_exists($checkFile)){
                                                $curFile = $this->downloadFile($imageURL,$this->tmpImageDir);
                                            } else {
                                                $curFile =  str_replace(PATH_site . "fileadmin","",$checkFile);
                                            }

                                            // Fal file
                                            $file           = $this->uploadImageToDefaultFolder($curFile,$target,$fileName);

                                            // Move and add
                                            $fileReference  = $this->objectManager->get('Klickfabrik\KfMobileDe\Domain\Model\FileReference');
                                            $fileReference->setOriginalResource($file);

                                            $newElement->addImage($fileReference);
                                            $pos++;
                                        }
                                    }
                                }

                                // clear
                                $value = "";
                                break;
                        }

                        if(!empty($value))
                            call_user_func_array(array($newElement, 'set' . ucfirst($key) ), array($value));

                    }

                    // Set PID für Taskmanager
                    if(!is_null($this->pid))
                        $newElement->setPid($this->pid);

                    // Check Import-Credentials
                    $newElement = $this->checkCredentials($newElement);

                    // Update & Insert
                    $objNew
                        ? $this->$rep->add($newElement)
                        : $this->$rep->update($newElement);
                }

                // Count
                $i++;
            }
        } else {
            exit('Konnte .xml nicht öffnen.');
        }
        $endtime = microtime(true);
        $timediff = $endtime - $starttime;

        $return = array(
            "count"     => $count,
            "filename"  => $filename,
            "time"      => $timediff,
            "status"    => $status,
        );

        if ($this->debug)
            return $return;
    }

    private function parseArrayValues(array $array){
        $return = [];
        foreach ($array as $name => $data){
            if(!isset($data['single']) && is_array($data)){
                $return[$name] = $this->parseArrayValues($data);
            } else {
                $value = isset($data['single'][0]) && !empty($data['single'][0]) ? $data['single'][0] : "";
                if(!empty($value)) {
                    $return[$name] = $value;
                }
            }
        }

        return $return;
    }


    /**
     * @param \Klickfabrik\KfMobileDe\Domain\Model\Vehicle $newElement
     * @return \Klickfabrik\KfMobileDe\Domain\Model\Vehicle
     */
    private function checkCredentials (\Klickfabrik\KfMobileDe\Domain\Model\Vehicle $newElement){
        $hidden = false;
        $checks = [
            "misc" => [
                "emissionConsumption"
            ]
        ];

        foreach ($checks as $checkKey => $checkValues){
            try {
                if(!empty($checkKey)){
                    $get = 'get' . ucfirst($checkKey);
                    $value = $newElement->$get();
                    $value = json_decode($value,true);

                    if(is_array($checkValues)){
                        foreach ($checkValues as $check){
                            if(empty($value[$check])){
                                $hidden = true;
                                break;
                            }
                        }
                    } else {
                        if(empty($value[$checkValues])){
                            $hidden = true;
                            break;
                        }
                    }
                }
            }
            catch(\Exception $exception) {
                // If the property mapper did throw a \TYPO3\CMS\Extbase\Property\Exception, because it was unable to find the requested entity, call the page-not-found handler.
                $previousException = $exception->getPrevious();
                if (($exception instanceof \TYPO3\CMS\Extbase\Property\Exception) && (($previousException instanceof \TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException) || ($previousException instanceof \TYPO3\CMS\Extbase\Property\Exception\InvalidSourceException))) {
                    $GLOBALS['TSFE']->pageNotFoundAndExit($this->entityNotFoundMessage);
                }
                throw $exception;
            }
        }

        // Change element
        if($hidden){
            $newElement->setHidden(true);
        } else {
            $newElement->setHidden(false);
        }

        return $newElement;
    }


    /**
     * @param array $imageData
     * @param bool $debug
     * @return array
     */
    private function parseImageData(array $imageData, $debug=false){
        $return = [];
        foreach ($imageData as $mainPos => $data){
            foreach ($data as $pos => $sizes){
                if(count($sizes) == 2){
                    if(isset($sizes['size'])){
                        $return[$mainPos][$sizes['size']] = $sizes['url'];
                    }
                } else {
                    foreach ($sizes as $size){
                        if(isset($size['size'])){
                            $return[$pos][$size['size']] = $size['url'];
                        } else {
                            $size = array_shift($size);
                            if(isset($size['size'])){
                                $return[$pos][$size['size']] = $size['url'];
                            }
                        }
                    }
                }
            }
        }

        if($debug){
            $this->showArray($return);exit();
        }
        return $return;
    }

    /**
     * @param $newElement
     */
    private function removeImages($newElement){
        $oldImages = $newElement->getImages();
        if(!empty($oldImages)){
            foreach ($oldImages as $refImage){
                $newElement->removeImage($refImage);
            }
        }

        if(count($newElement->getImages())>0){
            $this->removeImages($newElement);
        }
    }

    private function createSingleCalls($filename){
        $fileInfo = pathinfo($filename);

        $xml = new \DOMDocument();
        $xml->load($filename);

        $xmlArray  = \Klickfabrik\KfMobileDe\Helper\Dom2Array::xml_to_array($xml);
        foreach ($xmlArray['ads']['ad:ad'] as $vehicle){
            $url    = $vehicle['@attributes']['url'];
            $id     = $vehicle['@attributes']['key'];

            $res = self::downloadXML($this->mobileGetter,$id,$url);
            if($res['status'])
                $this->singleList[$fileInfo['basename']]["{$id}.xml"] = $res;
        }
    }



    /** ======================================================================================== **/
    /** System clean up */
    /** ======================================================================================== **/


    /**
     * Löschen alte nicht Import-Daten
     */
    private function checkInvalideData(){
        foreach ($this->checks as $rep => $data){

            $repDatas = $this->$rep->findAll();
            $call       = "get" . ucfirst($data['type']);

            foreach ($repDatas as $repData){
                $id     = $repData->$call();
                $import = $repData->getImport();

                // delete
                if($import && !in_array($id,$data['data'])){
                    if($rep == "vehicleRepository"){

                        # Fal remove
                        foreach ($repData->getImages() as $image){
                            $repData->removeImage($image);
                            #$this->deleteImage($image);
                        }

                        // Remove File
                        $target     = PATH_site . "fileadmin/" . $this->uploadFolder . $data['file'] . DIRECTORY_SEPARATOR;

                        # File & Folder remove
                        if(file_exists($target))
                            $this->removeDirectory($target);
                    }


                    // Remove Object
                    $this->$rep->remove($repData);
                }
            }
        }
    }


    /** ======================================================================================== **/
    /** Download, Upload & Temp händling */
    /** ======================================================================================== **/

    /**
     * @param $filename
     * @param string $content
     * @return string
     */
    public function uploadTmpFile($filename, $content){

        $tmpFile = $this->tmpDir . $filename;
        file_put_contents($tmpFile,$content);

        return $tmpFile;
    }


    /**
     * @param $filename
     * @return bool|int
     */
    private function unlinkUploadTmpFile($filename)
    {
        $unlink = 0;
        $tmpFile = $this->tmpDir . $filename;
        if (file_exists($tmpFile)) {
            $unlink = unlink($tmpFile);
        }

        return $unlink;
    }

    /**
     * @param $path
     */
    function removeDirectory($path) {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectory($file) : unlink($file);
        }
        rmdir($path);
        return;
    }


    /**
     * @param $MobileGetter
     * @param $client
     * @param bool $single
     * @return array
     */
    public function downloadXML($MobileGetter, $client, $single = false){

        $filename   = $single == false ? "{$client->getId()}.xml" : "{$client}.xml";
        $expireTime = 60 * 15;
        $fileTime   = file_exists( $this->tmpDir . $filename) ? filemtime( $this->tmpDir . $filename ) + $expireTime : 0;
        if($MobileGetter->isCheck()){

            if(time() < $fileTime){
                return array(
                    "file"  => $this->tmpDir . $filename,
                    "status"=> true,
                );
            }

            $starttime = microtime(true);
            $count  = self::getSellerCount($MobileGetter);
            $loops  = ceil($count / $this->pageSize);

            # Main DOM
            $xml = new \DOMDocument('1.0', 'UTF-8');
            $xml->formatOutput = true;
            $xml->loadXML('<ads />');

            # Mods for single-call
            $count = $single == false ? $count : 1;
            $loops = $single == false ? $loops : 1;

            for($i=1; $i <= $loops; $i++){
                if($single != false){
                    $result = $MobileGetter->execute($single,true);
                } else {
                    $result = $MobileGetter->execute("/search-api/search?page.size={$this->pageSize}&page.number={$i}");
                }

                if($result){
                    $child = new \DOMDocument();
                    $child->loadXML($result);
                    $ads = $child->getElementsByTagName( "ad" );

                    foreach($ads as $ad) {
                        $xml->documentElement->appendChild(
                            $xml->importNode($ad, TRUE)
                        );
                    }
                }
            }

            $endtime = microtime(true);
            $timediff = $endtime - $starttime;

            if($result){
                # Speichern
                return array(
                    "file"  => self::uploadTmpFile($filename,$xml->saveXML()),
                    "count" => $count,
                    "max"   => $this->pageSize,
                    "loops" => $loops,
                    "time"  => $timediff,
                    "status"=> true,
                );
            } else {
                return array(
                    "status"=> false,
                );
            }
        }
    }

    /**
     * @param $from
     * @param $to
     * @return bool|string
     */
    private function downloadFile($from, $to)
    {
        $pathinfo   = pathinfo($from);
        $source     = fopen($from, 'r');
        $target     = $to . $pathinfo['basename'];
        $result     = file_put_contents( $target , $source);

        return ($result) ? str_replace(PATH_site . "fileadmin","",$target) : false;
    }

    /** ======================================================================================== **/
    /** Curl functions */
    /** ======================================================================================== **/

    public function getSellerCount($MobileGetter){
        $result = $MobileGetter->execute("/search-api/search?page.size=1&page.number=");
        $xml = new \DOMDocument();
        $xml->loadXML($result);

        $total = $xml->getElementsByTagName( "total" )->item(0)->nodeValue;

        return $total;
    }


    /**
     * @param $MobileGetter
     * @param $execute
     * @param bool $raw
     * @return array|bool|\Klickfabrik\KfMobileDe\Helper\Ads2Value
     */
    public function getCurlInformation($MobileGetter, $execute, $raw = false){
        $result = $MobileGetter->execute($execute,true);

        if(!empty($result)){
            $xmlCurl = new \DOMDocument();
            $xmlCurl->formatOutput = true;
            $xmlCurl->loadXML($result);

            $xmlHelper = new \Klickfabrik\KfMobileDe\Helper\Dom2Array();
            $xmlArrayCurl = $xmlHelper::xml_to_array($xmlCurl);

            if($raw){
                return $xmlArrayCurl;
            }

            # XML Parsing (overwrite old XML!!!)
            $xmlAds = new \Klickfabrik\KfMobileDe\Helper\Ads2Value();
            $xmlAds->setXml($xmlArrayCurl,false);

            return $xmlAds;
        } else {
            return false;
        }
    }


    /**
     * @param $tmpFile
     * @param string $targetFolder
     * @param null $filename
     * @return \TYPO3\CMS\Core\Resource\FileInterface
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    private function uploadImageToDefaultFolder($tmpFile, $targetFolder="", $filename=null){

        $storageUid = 1;
        $fileInfo   = pathinfo($tmpFile, PATHINFO_BASENAME);
        $tarFolder  = !empty($targetFolder) ? $targetFolder : $this->uploadFolder;

        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $storage    = $resourceFactory->getStorageObject($storageUid);
        $folder     = $storage->getFolder($tarFolder);
        $fileExist  = $folder->hasFile($fileInfo);

        if(!$fileExist){
            $file       = $storage->getFile($tmpFile);
            $curFile    = $file->moveTo($folder,$filename);
        } else {
            $curFile    = $storage->getFile($folder->getIdentifier() . $fileInfo);
        }

        return $curFile;
    }


    /**
     * @param $file
     * @return bool
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException
     *
     * @url: http://blog.typo3servers.info/show/typo3-extbase-fal-removedelete-image/
     */
    private function deleteImage($file){
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $fileReferenceObject = $resourceFactory->getFileReferenceObject($file->getUid());
        $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();

        return $fileWasDeleted;
    }

    /** ======================================================================================== **/
    /** Helper functions */
    /** ======================================================================================== **/


    private function showArray($arr){
        echo "<pre>" . print_r($arr,true) . "</pre>";
    }

    /**
     * @param $string
     * @return bool
     */
    function isJson($string) {
        if(is_string($string)){
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        } else {
            return false;
        }
    }

    /**
     * @param string $subdir
     */
    private function createDefaultFolder($subdir=""){
        $dir = PATH_site . "/fileadmin/{$this->uploadFolder}{$subdir}";
        if(!file_exists($dir)){
            mkdir($dir,0777,true);
        }
    }

    /**
     * @param $xmlResult
     * @param $name
     * @return null
     */
    private function getValue($xmlResult, $name){
        $return = null;

        // MultiArray
        if(isset($xmlResult[$name]['data']) && is_array($xmlResult[$name]['data'])){
            $arr = $xmlResult[$name]['data'];
            $arr = array_shift($arr);
            return $arr['value'];
        }

        // single Array
        if(isset($xmlResult['data']) && is_array($xmlResult['data'])){
            $arr = $xmlResult['data'];
            $arr = array_shift($arr);
            return $arr['value'];
        }

        return $return;
    }

    /**
     *
     */
    private function saveData(){
        # Den Vorschlaghammer instanzieren / aus der Kiste kramen
        $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");

        # Mit dem Vorschlaghammer in die Datenbank speichern / Nägel mit Köpfen machen
        $persistenceManager->persistAll();
    }



    /* **************************************************************************** */
    /* Scheduler Task */


    /**
     * @param bool $return
     * @param array $args
     * @return array
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    public function runAutoImport($return=true, $args=array()){
        $result = [];

        if(isset($args['storageID']) && !empty($args['storageID'])){
            $starttime = microtime(true);

            // set PID
            $this->pid = $args['storageID'];

            $ids = explode(",",$args['storageID']);
            $this->setStorageID($ids);

            $endtime = microtime(true);
            $timediff = $endtime - $starttime;

            $result[] = [
                "task"  => "setStorageID()",
                "data"  => $args['storageID'],
                "time"  => $timediff,
            ];
        }

        if(isset($args['tasks']) && !empty($args['tasks'])){
            // Multi call
            foreach ($args['tasks'] as $task){
                $starttime = microtime(true);
                $this->checkImportAction($return,$task);
                $endtime = microtime(true);
                $timediff = $endtime - $starttime;

                $result[] = [
                    "type"  => "multi",
                    "task"  => "checkImportAction()",
                    "args"  => json_encode($task),
                    "time"  => $timediff,
                ];
            }
        } else {
            $starttime = microtime(true);
            $result = $this->checkImportAction($return,$args);
            $endtime = microtime(true);
            $timediff = $endtime - $starttime;

            $result[] = [
                "type"  => "single",
                "task"  => "checkImportAction()",
                "args"  => json_encode($args),
                "time"  => $timediff,
            ];
        }

        return $result;
    }

    /**
     * @param array $storageIDs
     */
    private function setStorageID(array $storageIDs){
        $reps = array(
            "clientsRepository",
            "featuresRepository",
            "importerRepository",
            "sellerRepository",
            "specificsRepository",
            "vehicleRepository",
        );

        $res = array();
        foreach ($reps as $rep){
            $res[] = $this->$rep->setDefaultStorage($storageIDs);
        }
    }
    /* **************************************************************************** */


}

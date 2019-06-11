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
 * SellerController
 */
class SellerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * sellerRepository
     *
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\SellerRepository
     * @inject
     */
    protected $sellerRepository = null;

    /**
     * vehicleRepository
     *
     * @var \Klickfabrik\KfMobileDe\Domain\Repository\VehicleRepository
     * @inject
     */
    protected $vehicleRepository = null;

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $this->googleMaps();
    }

    # ========================================================================================
    # Google Maps
    # ========================================================================================
    public function mapsAction()
    {
        #Debug
        $this->debug();
        # single seller
        $seller = $this->getCurrentSellers();
        $data = $this->getGoogleMaps($seller);
        $this->view->assign('sellers', $data['sellers']);
        $this->view->assign('phones', $data['phones']);
        $this->view->assign('google_data', json_encode($data['googleData']));
        $this->view->assign('google_id', 'map_' . rand(0, 9999));
        $this->view->assign('accordion_id', 'accordion' . rand(0, 999));
    }

    /**
     * @param array $_seller
     * @return array
     */
    public function getGoogleMaps($_seller = [])
    {
        if (empty($_seller) || is_null($_seller)) {
            $_seller = $this->sellerRepository->findAll();
        }
        // Check Type (detail-page)
        if (is_a($_seller, 'Klickfabrik\\KfMobileDe\\Domain\\Model\\Seller')) {
            $_seller = [$_seller];
        }
        $sellers = [];
        $phones = [];
        $googleData = [];
        foreach ($_seller as $seller) {
            $phone = $this->parsePhone($seller->getPhone());
            $googleData[] = [
                'latitude' => $seller->getLatitude(),
                'longitude' => $seller->getLongitude(),
                'name' => $seller->getCompanyName(),
                'address' => join(',<br/>', [
                        "<strong>{$seller->getCompanyName()}</strong>",
                        $seller->getStreet(),
                        $seller->getZipcode() . ' ' . $seller->getCity(),
                        join('<br/>', $phone['maps'])
                    ])
            ];
            $phones[] = $phone['raw'];
            $sellers[] = $seller;
        }
        $return = [
            'sellers' => $sellers,
            'phones' => $phones,
            'googleData' => $googleData,
            'count' => count($_seller)
        ];
        return $return;
    }

    /**
     * @param $object
     * @param $skip
     * @return array
     */
    private function parsePhone($object, $skip = ['fax'])
    {
        $phone = [];
        $maps = [];
        $translate = [
            'FIXED' => 'Tel.',
            'FAX' => 'Fax',
            'CELL' => 'Mobil'
        ];
        foreach (json_decode($object, true) as $entry) {
            if (!empty($skip) && in_array(strtolower($entry['type']), $skip)) {
                continue;
            }
            $number = $entry['country-calling-code'] . substr($entry['area-code'], 1) . $entry['number'];
            $array = [
                'type' => $translate[$entry['type']],
                'number' => "+{$number}"
            ];
            $phone[md5($number)] = $array;
            $maps[md5($number)] = join(': ', $array);
        }
        return [
            'raw' => $phone,
            'maps' => $maps
        ];
    }

    # ========================================================================================
    # System helper
    # ========================================================================================
    private function debug()
    {
        if (isset($this->settings['debug']) && $this->settings['debug']) {
            $this->showArray($this->settings);
        }
    }

    /**
     * @return array
     */
    public function getCurrentSellers()
    {
        # single seller
        if (isset($this->settings['select']['seller']) && !empty($this->settings['select']['seller'])) {
            $seller = [];
            $uids = explode(',', $this->settings['select']['seller']);
            foreach ($uids as $uid) {
                $seller[] = $this->sellerRepository->findByUid($uid);
            }
        } else {
            $seller = $this->sellerRepository->findAll();
        }
        return $seller;
    }

    # ========================================================================================
    # Helpers
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

    /**
     * action places
     *
     * @return void
     */
    public function placesAction()
    {

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: marcfinnern
 * Date: 11.05.18
 * Time: 18:40
 */

namespace Klickfabrik\KfMobileDe\Helper;


class MobileGetter
{
    public $lang = "de";

    private $needConfig = array("username","password");
    private $check = false;

    private $username;
    private $password;
    private $api_base = 'https://services.mobile.de/';

    function __construct($config){
       self::checkConfig($config);
    }

    /**
     * @param $config
     * @return array|bool
     */
    private function checkConfig($config){
        $missing = array();
        foreach ($config as $key => $value){
            if(in_array($key,$this->needConfig)){
                $this->$key = $value;
            } else {
                array_push($missing,$key);
            }
        }

        $this->check = !empty($missing) ? false : true;
    }


    /**
     * @return bool
     */
    public function isCheck(): bool
    {
        return $this->check;
    }

    /**
     * @param bool $check
     */
    public function setCheck(bool $check)
    {
        $this->check = $check;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getApiBase()
    {
        return $this->api_base;
    }

    /**
     * @param mixed $api_base
     */
    public function setApiBase($api_base)
    {
        $this->api_base = $api_base;
    }

    /**
     * @param $query
     * @return mixed
     */
    function execute($query,$fullURL=false){
        /* executes the query on remote API */

        $curlURL = $fullURL ? $query : $this->api_base . $query;

        $curl = curl_init($curlURL);
        $this->curl_set_options($curl);
        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        curl_close($curl);

        if($curl_error){
            echo "<pre>";
            print_r(array(
                $curl_error,
                $this->get_auth_string(),
                $curlURL,
            ));
            echo "</pre>";
        }

        return $response;
    }

    /**
     * @url: https://www.phpied.com/simultaneuos-http-requests-in-php-with-curl/
     * @param $data
     * @param array $options
     * @return array
     */
    function multiRequest($data, $options = array()) {

        // array of curl handles
        $curly = array();
        // data to be returned
        $result = array();

        // multi handle
        $mh = curl_multi_init();

        // loop through $data and create curl handles
        // then add them to the multi-handle
        foreach ($data as $id => $d) {

            $curly[$id] = curl_init();

            $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
            curl_setopt($curly[$id], CURLOPT_URL,            $url);
            curl_setopt($curly[$id], CURLOPT_HEADER,         0);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);

            // post?
            if (is_array($d)) {
                if (!empty($d['post'])) {
                    curl_setopt($curly[$id], CURLOPT_POST,       1);
                    curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
                }
            }

            // extra options?
            if (!empty($options)) {
                curl_setopt_array($curly[$id], $options);
            }

            curl_multi_add_handle($mh, $curly[$id]);
        }

        // execute the handles
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running > 0);


        // get content and remove handles
        foreach($curly as $id => $c) {
            $result[$id] = curl_multi_getcontent($c);
            curl_multi_remove_handle($mh, $c);
        }

        // all done
        curl_multi_close($mh);

        return $result;
    }

    /**
     * @return string
     */
    function get_auth_string(){
        /* e.g. "myusername:mypassword" */
        return $this->username.":".$this->password;
    }

    /**
     * @param $ch
     */
    function curl_set_options($ch){
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ); // HTTP Basic Auth
        curl_setopt($ch, CURLOPT_USERPWD, $this->get_auth_string()); // Auth String
        curl_setopt($ch, CURLOPT_FAILONERROR, true); // Throw exception on error
        curl_setopt($ch, CURLOPT_HEADER, false); // Do not retrieve header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retrieve HTTP Body
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeader());
        #curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        #curl_setopt($ch, CURLOPT_TIMEOUT, 2); //timeout in seconds
    }

    /**
     * @param array $newHeader
     * @return array
     */
    public function getHeader($newHeader=array()){
        $defautHeader = array(
            "Accept-Language: {$this->lang}"
        );

        if(!empty($newHeader)){
            $defautHeader = array_merge($defautHeader,$newHeader);
        }

        return $defautHeader;
    }
}
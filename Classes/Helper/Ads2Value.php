<?php
/**
 * Created by PhpStorm.
 * User: marcfinnern
 * Date: 10.05.18
 * Time: 22:09
 */

namespace Klickfabrik\KfMobileDe\Helper;


class Ads2Value
{

    public static $xml;
    public static $count;
    public static $pos          = null;
    public static $preParse     = true;
    public static $mode         = "";
    private static $specifics   = array(
        "ad:vehicle",
        "ad:price",
        "ad:class",
        "ad:category",
        "ad:make",
        "ad:model",
        //"ad:model-description",
        "ad:specifics",
        "ad:fuel",
        "ad:power",
        "ad:gearbox",
        "ad:condition",
        "ad:usage-type",
        "seller:seller",

        "ad:emission-class",
        "ad:emission-sticker",
        "ad:condition",
        "ad:usage-type",
        "ad:sliding-door-type",
    );

    /**
     * @return mixed
     */
    public static function getXml()
    {
        return self::$xml;
    }


    /**
     * @param $xml
     * @param bool $preParse
     * @param string $mode
     */
    public static function setXml($xml, $preParse = true, $mode = "")
    {

        if($preParse){
            $xml = array_shift($xml);
            $xml = array_shift($xml);
        }

        if($mode == "single"){
            $xmlTemp    = $xml;
            $xml        = array();
            $xml[]      = $xmlTemp;
        }

        self::$preParse = $preParse;
        self::$mode     = $mode;
        self::$xml      = $xml;
        self::$count    = count(self::$xml);
        self::$pos      = null;
    }


    /**
     * @param string $mode
     * @return array|mixed
     */
    public static function getFeatures($mode="")
    {
        if($mode == "single"){
            $start = array();
            $start[] = self::$xml;
        } else {
            $start          = self::$xml;
        }

        $featuresAll    = array();
        $features       = array();
        foreach ($start as $pos => $ad){
            $feature_start = $ad['ad:vehicle']['ad:features']['ad:feature'];
            foreach ($feature_start as $feature){
                $key    = $feature['@attributes']['key'];
                $value  = $feature['resource:local-description']['_value'];

                if($value) {
                    $features[$pos][] = array(
                        "key"   => $key,
                        "value" => $value,
                    );

                    if (isset($featuresAll[$key])) {
                        $featuresAll[$key]['count']++;
                    } else {
                        $featuresAll[$key] = array(
                            "key"   => $key,
                            "value" => $value,
                            "count" => 1,
                        );
                    }
                }
            }
        }

        if(!is_null(self::$pos)){
            return $features[self::$pos];
        }

        return array(
            "all"   => $featuresAll,
            "steps" => $features,
        );
    }

    /**
     * @param string $mode
     * @return array
     */
    public static function getSpecifics($mode="")
    {
        if($mode == "single"){
            $start = array();
            $start[] = self::$xml;
        } else {
            $start          = self::$xml;
        }

        $spectsAll  = array();
        $spects     = array();
        foreach ($start as $pos => $ad){
            $feature_start = $ad['ad:vehicle']['ad:specifics'];
            foreach (self::$specifics as $tagValue){
                $curSpec = $feature_start[$tagValue];
                $key    = $curSpec['@attributes']['key'];
                $value  = $curSpec['resource:local-description']['_value'];

                if($value){
                    $spects[$pos][] = array(
                        "key"   => $key,
                        "value" => $value,
                    );

                    if(isset($spectsAll[$key])){
                        $spectsAll[$key]['count']++;
                    } else {
                        $spectsAll[$key] = array(
                            "key"   => $key,
                            "value" => $value,
                            "count" => 1,
                        );
                    }
                }
            }
        }
        return array(
            "all"   => $spectsAll,
            "steps" => $spects,
        );
    }

    /**
     * @param $xmlArray
     * @param string $tag
     * @return array
     */
    public static function getTag($tag='ad:category',$valueKey="")
    {
        $start = self::$xml;


        $categories = array(
            'single'    => array(),
            'data'      => array(),
        );

        $pos    = self::$pos;
        $key    = $pos;
        $data   = is_null(self::$pos) ? $start : $start[self::$pos];

        if(!empty($tag)){
            $tags   = explode("|",$tag);
            foreach ($tags as $step){
                $data   = $data[$step];
            }
        }

        // Array Daten
        if(is_array($data)){
            if(isset($data['@attributes']['key'])){
                $key    = $tag.$pos;
                $value  = $data['resource:local-description']['_value'];
            }

            if(isset($data['@attributes']['value'])) {
                $key    = $tag.$pos;
                $value  = $data['@attributes']['value'];
            }

            if(!empty($valueKey) && isset($data['@attributes'][$valueKey])){
                $key    = $valueKey.$pos;
                $value  = $data['@attributes'][$valueKey];
            }

            if(empty($value) && empty($valueKey)){
                $res = array();
                foreach ($data as $entry){
                    $res[] = isset($entry['@attributes']) ? $entry['@attributes'] : $entry;
                }
                $value = json_encode($res);
            }
        }

        // String
        if(is_string($data)){
            $value = $data;
        }


        if(isset($categories[$key])){
            $categories['data'][$key]['count']++;
        } else {

            if(is_string($value)){
                $categories['data'][$key] = array(
                    "key"   => $key,
                    "value" => htmlspecialchars_decode($value),
                    "count" => 1,
                );
            }

            if(!in_array($value,$categories['single'])){
                $categories['single'][] = $value;
            }
        }

        return $categories;
    }

    public static function getTagValue($tag='ad:category',$valueKey=""){
        $res = self::getTag($tag,$valueKey);

        $data = array_shift($res['data']);
        return $data['value'];
    }


    /**
     * @return mixed
     */
    public static function getCount(){
        return self::$count;
    }

    /**
     * @param $tag
     * @param string $valueKey
     * @return int
     */
    public static function getCountByTag($tag, $valueKey=""){
        $data = self::getTag($tag,$valueKey);

        return count($data['single']);
    }

    /**
     * @param int $pos
     */
    public static function setPos($pos)
    {
        self::$pos = $pos;
    }

    /**
     * @param bool $preParse
     */
    public static function setPreParse(bool $preParse)
    {
        self::$preParse = $preParse;
    }

    /**
     * @param $arr
     */
    private static function showArray($arr){
        echo "<pre>" . print_r($arr,true) . "</pre>";
    }
}
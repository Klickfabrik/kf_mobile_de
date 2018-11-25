<?php
/**
 * Created by PhpStorm.
 * User: marcfinnern
 * Date: 10.05.18
 * Time: 22:09
 */

namespace Klickfabrik\KfMobileDe\Helper;


class Dom2Array
{
    /**
     * @param $root
     * @return array
     */
    public static function Dom2Array($root) {
        $array = array();
        //list attributes
        if($root->hasAttributes()) {
            foreach($root->attributes as $attribute) {
                $array['_attributes'][$attribute->name] = $attribute->value;
            }
        }
        //handle classic node
        if($root->nodeType == XML_ELEMENT_NODE) {
            $array['_type'] = $root->nodeName;
            if($root->hasChildNodes()) {
                $children = $root->childNodes;
                for($i = 0; $i < $children->length; $i++) {
                    $child = self::Dom2Array( $children->item($i) );
                    //don't keep textnode with only spaces and newline
                    if(!empty($child)) {
                        $array['_children'][] = $child;
                    }
                }
            }
            //handle text node
        } elseif($root->nodeType == XML_TEXT_NODE || $root->nodeType == XML_CDATA_SECTION_NODE) {
            $value = $root->nodeValue;
            if(!empty($value)) {
                $array['_type'] = '_text';
                $array['_content'] = $value;
            }
        }
        return $array;
    }


    /**
     * @param $array
     * @param null $doc
     * @return DOMDocument
     */
    public static function  Array2Dom($array, $doc = null) {
        if($doc == null) {
            $doc = new DOMDocument();
            $doc->formatOutput = true;
            $currentNode = $doc;
        } else {
            if($array['_type'] == '_text')
                $currentNode = $doc->createTextNode($array['_content']);
            else
                $currentNode = $doc->createElement($array['_type']);
        }
        if($array['_type'] != '_text') {
            if(isset($array['_attributes'])) {
                foreach ($array['_attributes'] as $name => $value) {
                    $currentNode->setAttribute($name, $value);
                }
            }
            if(isset($array['_children'])) {
                foreach($array['_children'] as $child) {
                    $childNode = self::Array2Dom($child, $doc);
                    $childNode = $currentNode->appendChild($childNode);
                }
            }
        }
        return $currentNode;
    }

    public static function  xml_to_array($root) {
        $result = array();

        if ($root->hasAttributes()) {
            $attrs = $root->attributes;
            foreach ($attrs as $attr) {
                $result['@attributes'][$attr->name] = $attr->value;
            }
        }

        if ($root->hasChildNodes()) {
            $children = $root->childNodes;
            if ($children->length == 1) {
                $child = $children->item(0);
                if ($child->nodeType == XML_TEXT_NODE) {
                    $result['_value'] = $child->nodeValue;
                    return count($result) == 1
                        ? $result['_value']
                        : $result;
                }
            }
            $groups = array();
            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $res = self::xml_to_array($child);
                    if(!empty($res))
                        $result[$child->nodeName] = $res;
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $result[$child->nodeName] = array($result[$child->nodeName]);
                        $groups[$child->nodeName] = 1;
                    }
                    $res = self::xml_to_array($child);
                    if(!empty($res))
                        $result[$child->nodeName][] = $res;
                }
            }
        }

        return $result;
    }
}
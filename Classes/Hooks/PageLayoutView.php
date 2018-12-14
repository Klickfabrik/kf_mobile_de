<?php
namespace Klickfabrik\KfMobileDe\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */


class PageLayoutView implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface {

    private $header = 'KF: Mobile.de Plugin';
    private $allow = [
        'settings.layout' => "Layout",
        'switchableControllerActions' => "Controller",
        'settings.order' => "Sorting"
    ];

    /**
     * Preprocesses the preview rendering of a content element.
     *
     * @param PageLayoutView $parentObject Calling parent object
     * @param boolean $drawItem Whether to draw the item using the default functionalities
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     * @return void
     */
    public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row) {

        //depending on your list type!!
        if ($row['list_type'] !== 'kfmobilede_kfmobileview') {
            return;
        }

        $drawItem = FALSE;
        $content = [];
        $filters = [];

        $headerContent = "<strong>{$this->header}</strong><br>";

        $flexform = $row['pi_flexform'];

        //fetch the xml fleform value and get the value (field[0] - this depends on your own flexform)
        //see article on this page "XML Dateien in Extbase"
        $xml = simplexml_load_string($flexform);

        $pluginXML = [];
        foreach ($xml->data->sheet->language->field as $field){
            $name = strip_tags($field->attributes()->index);
            $data = htmlspecialchars_decode(strip_tags($field->value->asXML()));
            $pluginXML[$name] = [
                'name' => $name,
                'data' => $data,
            ];
        }

        foreach ($pluginXML as $field){
            $name = $field['name'];
            $data = $field['data'];
            if(in_array($name,array_keys($this->allow)) && !empty($data)){
                $name = isset($this->allow[$name]) && !empty($this->allow[$name]) ? $this->allow[$name] : $name;
                $filters[] = "{$name}: {$data}";
            }
        }

        asort($filters);
        $uid = strip_tags($xml->data->sheet->language->field[0]->value->asXML());
        $layout = !empty($uid) ? $uid : "-";
        $content[] = "Layout: " . $layout;

        if(!empty($filters)){
            $content[] = "";
            $content[] = "<strong>Filter</strong>:";
            $content[] = join("<br/>",$filters);
        }


        $itemContent = join("<br/>",$content);
    }

    private function backup($uid)
    {
        //we are in a Hook, make instance by your own pls ^^//
        /** @var $extbaseObjectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $extbaseObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        /** @var $articleRepository \T3dev\T3devTemplate\Domain\Repository\ArticleRepository */
        $articleRepository = $extbaseObjectManager->get('T3dev\\T3devTemplate\\Domain\\Repository\\ArticleRepository');

        //We get a normal e.g. article model with all standard getters!
        $article = $articleRepository->findByUid($uid);

        $itemContent = $article->getTitle();
        $itemContent.= '<br>';

        $images = $article->getImage();

        //the image model in this case is of type ObjectStorage, so there could be more than one image
        foreach($images as $img){
            $imagePath =  $img->getOriginalResource()->getPublicUrl();
            $itemContent.= '<image src="/' . $imagePath . '" width="50px" />';
        }
    }
}
<?php
defined('TYPO3_MODE') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'KfMobileDe',
        'Kfmobileview',
        [
            \Klickfabrik\KfMobileDe\Controller\VehicleController::class => 'list, show, search, ajaxResult',
            \Klickfabrik\KfMobileDe\Controller\SellerController::class => 'maps',
            \Klickfabrik\KfMobileDe\Controller\ClientsController::class => 'places'
        ],
        // non-cacheable actions
        [
            \Klickfabrik\KfMobileDe\Controller\VehicleController::class => 'create, update, delete',
            \Klickfabrik\KfMobileDe\Controller\FeaturesController::class => 'create, update, delete',
            \Klickfabrik\KfMobileDe\Controller\SpecificsController::class => 'create, update, delete'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    kfmobileview {
                        iconIdentifier = kf_mobile_de-plugin-kfmobileview
                        title = LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kf_mobile_de_kfmobileview.name
                        description = LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kf_mobile_de_kfmobileview.description
                        tt_content_defValues {
                            CType = list
                            list_type = kfmobilede_kfmobileview
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'kf_mobile_de-plugin-kfmobileview',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:kf_mobile_de/Resources/Public/Icons/user_plugin_kfmobileview.svg']
    );
})();

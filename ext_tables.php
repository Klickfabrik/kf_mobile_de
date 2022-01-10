<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Klickfabrik.KfMobileDe',
            'Kfmobileview',
            'Mobile.de'
        );

        $pluginSignature = str_replace('_', '', 'kf_mobile_de') . '_kfmobileview';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:kf_mobile_de/Configuration/FlexForms/flexform_kfmobileview.xml');

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'Klickfabrik.KfMobileDe',
                'web', // Make module a submodule of 'web'
                'kfmobileimport', // Submodule key
                '', // Position
                [
                    'Importer' => 'list, show, new, create, checkImport',
                    'Vehicle' => 'list, show, new, create, edit, update, delete, search, ajaxResult',
                    'Features' => 'list, new, create, edit, update, delete',
                    'Specifics' => 'list, new, create, edit, update, delete',
                    'Seller' => 'maps',
                    'Clients' => 'places',
                    
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:kf_mobile_de/Resources/Public/Icons/user_mod_kfmobileimport.svg',
                    'labels' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_kfmobileimport.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('kf_mobile_de', 'Configuration/TypoScript', 'KF - Mobile.de');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kfmobilede_domain_model_clients', 'EXT:kf_mobile_de/Resources/Private/Language/locallang_csh_tx_kfmobilede_domain_model_clients.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kfmobilede_domain_model_clients');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kfmobilede_domain_model_vehicle', 'EXT:kf_mobile_de/Resources/Private/Language/locallang_csh_tx_kfmobilede_domain_model_vehicle.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kfmobilede_domain_model_vehicle');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kfmobilede_domain_model_features', 'EXT:kf_mobile_de/Resources/Private/Language/locallang_csh_tx_kfmobilede_domain_model_features.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kfmobilede_domain_model_features');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kfmobilede_domain_model_specifics', 'EXT:kf_mobile_de/Resources/Private/Language/locallang_csh_tx_kfmobilede_domain_model_specifics.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kfmobilede_domain_model_specifics');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kfmobilede_domain_model_seller', 'EXT:kf_mobile_de/Resources/Private/Language/locallang_csh_tx_kfmobilede_domain_model_seller.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kfmobilede_domain_model_seller');

    }
);

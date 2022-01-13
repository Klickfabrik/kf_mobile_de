<?php
defined('TYPO3_MODE') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'KfMobileDe',
        'web',
        'kfmobileimport',
        '',
        [
            \Klickfabrik\KfMobileDe\Controller\ImporterController::class => 'list, show, new, create, checkImport',
            \Klickfabrik\KfMobileDe\Controller\VehicleController::class => 'list, show, new, create, edit, update, delete, search, ajaxResult',
            \Klickfabrik\KfMobileDe\Controller\FeaturesController::class => 'list, new, create, edit, update, delete',
            \Klickfabrik\KfMobileDe\Controller\SpecificsController::class => 'list, new, create, edit, update, delete',
            \Klickfabrik\KfMobileDe\Controller\SellerController::class => 'maps',
            \Klickfabrik\KfMobileDe\Controller\ClientsController::class => 'places',
            
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:kf_mobile_de/Resources/Public/Icons/user_mod_kfmobileimport.svg',
            'labels' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_kfmobileimport.xlf',
        ]
    );

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
})();

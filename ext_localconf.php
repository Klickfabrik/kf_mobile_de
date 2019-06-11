<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Klickfabrik.KfMobileDe',
            'Kfmobileview',
            [
                'Importer' => 'list, show, new, create, checkImport',
                'Vehicle' => 'list, show, new, create, edit, update, delete, search, ajaxResult',
                'Features' => 'list, new, create, edit, update, delete',
                'Specifics' => 'list, new, create, edit, update, delete',
                'Seller' => 'maps',
                'Clients' => 'places'
            ],
            // non-cacheable actions
            [
                'Vehicle' => 'create, update, delete',
                'Features' => 'create, update, delete',
                'Specifics' => 'create, update, delete'
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
		
    }
);

/**
 * Registering class to scheduler
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Klickfabrik\\KfMobileDe\\Controller\\ImportCommandController';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] = \Klickfabrik\KfMobileDe\Hooks\PageLayoutView::class;
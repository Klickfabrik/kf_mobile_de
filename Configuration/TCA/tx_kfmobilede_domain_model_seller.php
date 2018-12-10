<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller',
        'label' => 'company_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'company_name,phone,street,zipcode,city,country_code,latitude,longitude,seller_image,seller_info,url,email,commercial,import_key,import',
        'iconfile' => 'EXT:kf_mobile_de/Resources/Public/Icons/tx_kfmobilede_domain_model_seller.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, company_name, phone, street, zipcode, city, country_code, latitude, longitude, seller_image, seller_info, url, email, commercial, import_key, import',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, company_name, phone, street, zipcode, city, country_code, latitude, longitude, seller_image, seller_info, url, email, commercial, import_key, import, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_kfmobilede_domain_model_seller',
                'foreign_table_where' => 'AND tx_kfmobilede_domain_model_seller.pid=###CURRENT_PID### AND tx_kfmobilede_domain_model_seller.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'company_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.company_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.phone',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'zipcode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.zipcode',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'country_code' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.country_code',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'latitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.latitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'longitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.longitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'seller_image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.seller_image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'seller_image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'seller_info' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.seller_info',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            
        ],
        'url' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'commercial' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.commercial',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
        'import_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.import_key',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'import' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_seller.import',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
            
        ],
    
    ],
];

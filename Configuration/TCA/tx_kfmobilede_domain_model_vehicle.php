<?php

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

return [
    'ctrl' => [
        'title' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle',
        'label' => 'model_description',
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
        'searchFields' => 'model_description,class,category,make,model,price,damage_and_unrepaired,accident_damaged,roadworthy,price_type,fuel,gearbox,color,mileage,seats,doors,power,cubic_capacity,emission_class,images,description,misc,consumer_price_amount,dealer_price_amount,first_registration,creation_date,modification_date,detail_page,import_key,import_client,import,custom1,custom2,custom3,custom4,custom5,features,specifics,seller',
        'iconfile' => 'EXT:kf_mobile_de/Resources/Public/Icons/tx_kfmobilede_domain_model_vehicle.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, model_description, class, category, make, model, price, damage_and_unrepaired, accident_damaged, roadworthy, price_type, fuel, gearbox, color, mileage, seats, doors, power, cubic_capacity, emission_class, images, description, misc, consumer_price_amount, dealer_price_amount, first_registration, creation_date, modification_date, detail_page, import_key, import_client, import, custom1, custom2, custom3, custom4, custom5, features, specifics, seller',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, model_description, class, category, make, model, price, damage_and_unrepaired, accident_damaged, roadworthy, price_type, fuel, gearbox, color, mileage, seats, doors, power, cubic_capacity, emission_class, images, description, misc, consumer_price_amount, dealer_price_amount, first_registration, creation_date, modification_date, detail_page, import_key, import_client, import, custom1, custom2, custom3, custom4, custom5, features, specifics, seller, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_kfmobilede_domain_model_vehicle',
                'foreign_table_where' => 'AND tx_kfmobilede_domain_model_vehicle.pid=###CURRENT_PID### AND tx_kfmobilede_domain_model_vehicle.sys_language_uid IN (-1,0)',
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

        'model_description' => [
            'exclude' => false,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.model_description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'class' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.class',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'category' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.category',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'make' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.make',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'model' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.model',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'price' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.price',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'damage_and_unrepaired' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.damage_and_unrepaired',
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
        'accident_damaged' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.accident_damaged',
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
        'roadworthy' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.roadworthy',
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
        'price_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.price_type',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'fuel' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.fuel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'gearbox' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.gearbox',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'color' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.color',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'mileage' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.mileage',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'seats' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.seats',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'doors' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.doors',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'power' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.power',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'cubic_capacity' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.cubic_capacity',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'emission_class' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.emission_class',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'images' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.images',
            'config' => 
            ExtensionManagementUtility::getFileFieldTCAConfig(
                'images',
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
                        File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 20
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.description',
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
        'misc' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.misc',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'consumer_price_amount' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.consumer_price_amount',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'dealer_price_amount' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.dealer_price_amount',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'first_registration' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.first_registration',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime',
                'default' => null,
            ],
        ],
        'creation_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.creation_date',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime',
                'default' => null,
            ],
        ],
        'modification_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.modification_date',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime',
                'default' => null,
            ],
        ],
        'detail_page' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.detail_page',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'import_key' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.import_key',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'import_client' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.import_client',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'import' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.import',
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
        'custom1' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.custom1',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'custom2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.custom2',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'custom3' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.custom3',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'custom4' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.custom4',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'custom5' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.custom5',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'features' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.features',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_kfmobilede_domain_model_features',
                'MM' => 'tx_kfmobilede_vehicle_features_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
            
        ],
        'specifics' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.specifics',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_kfmobilede_domain_model_specifics',
                'MM' => 'tx_kfmobilede_vehicle_specifics_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
            
        ],
        'seller' => [
            'exclude' => true,
            'label' => 'LLL:EXT:kf_mobile_de/Resources/Private/Language/locallang_db.xlf:tx_kfmobilede_domain_model_vehicle.seller',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_kfmobilede_domain_model_seller',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    
    ],
];

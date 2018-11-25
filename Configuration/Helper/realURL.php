<?php

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT'] = array(
    'init' => array(
    ),
    'postVarSets' => array(
        '_DEFAULT' => array(

            ## klickfabrik
            'kf_mobile' => array(
                array(
                    'GETvar' => 'tx_kfmobilede_kfmobileview[action]',
                    //'noMatch' => 'bypass',
                    // Action verschwindet aus der URL
                ),
                array(
                    'GETvar' => 'tx_kfmobilede_kfmobileview[controller]',
                    'noMatch' => 'bypass',
                    // Action verschwindet aus der URL
                ),

                // Domain Model UID & CHASH verschwindet aus der URL
                array(
                    'GETvar' => 'tx_kfmobilede_kfmobileview[vehicle]',
                    'lookUpTable' => array(
                        'table' => 'tx_kfmobilede_domain_model_vehicle',
                        'id_field' => 'uid',
                        'alias_field' => 'model_description',
                        'addWhereClause' => ' AND NOT deleted',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => array(
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ),
                        'languageGetVar' => 'L',
                        'languageExceptionUids' => '',
                        'languageField' => 'sys_language_uid',
                        'transOrigPointerField' => 'l10n_parent',
                        'autoUpdate' => 1,
                        'expireDays' => 180,
                    ),
                ),
            ),
        ),
    ),
);
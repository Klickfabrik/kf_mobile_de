<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'KF - Mobile.de',
    'description' => 'a plugin to show the mobile.de data in typo3',
    'category' => 'plugin',
    'author' => 'Marc Finnern',
    'author_email' => 'typo3@klickfabrik.net',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-11.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

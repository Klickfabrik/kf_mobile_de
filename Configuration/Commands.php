<?php
declare(strict_types = 1);

use In2code\Powermail\Command\CleanupExportsCommand;
use In2code\Powermail\Command\CleanupUnusedUploadsCommand;
use In2code\Powermail\Command\CleanupUploadsCommand;
use In2code\Powermail\Command\ExportCommand;
use In2code\Powermail\Command\ResetMarkersCommand;
use Klickfabrik\KfMobileDe\Command\MobileImportCommand;

return [
    'kfmobilede:mobileimport' => [
        'class' => MobileImportCommand::class,
        'schedulable' => true
    ],
];

<?php
declare(strict_types=1);

namespace Klickfabrik\KfMobileDe\Command;

use Klickfabrik\KfMobileDe\Controller\ImporterController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;

/**
 * Class ImportCommand
 */
class MobileImportCommand extends Command
{

    private $mailFrom = 'noreply@typo3.de';
    private $mailSubject = 'Typo3: ImporterController';

    /**
     * @return void
     */
    public function configure()
    {
        $description = 'Create import from mobile.de';
        $this
            ->setDescription($description)
            ->addArgument(
                'storageID',
                InputArgument::REQUIRED,
                'Target-Import-Folder'
            )
            ->addArgument(
                'sendMail',
                InputArgument::OPTIONAL,
                'Send report email'
            )
            ->addArgument(
                'to',
                InputArgument::OPTIONAL,
                'email receiver'
            );
    }


    /**
     * Own export command to export whole pagetrees with all records to a file which contains a json and can be
     * imported again with a different import command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws InvalidConfigurationTypeException
     * @throws InvalidExtensionNameException
     * @throws Exception
     * @throws InvalidQueryException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {

        try {
            $config = [
                'storageID' => $input->getArgument('storageID'),
                'tasks' => [
                    ['import' => 1],
                    ['status' => 1],
                    ['update_force' => 1],
                ]
            ];

            $businessLogic = GeneralUtility::makeInstance(ImporterController::class);
            $res = $businessLogic->runAutoImport(true, $config);
        } catch (Exception $e) {
            $res = sprintf("Exception abgefangen:%s\n", $e->getMessage());
        }

        if ((int)$input->getArgument('sendMail')) {
            $this->sendMail($res, $input->getArgument('to'));
        }

        return 0;
    }

    /**
     * @param string $message
     * @param string $to
     */
    private function sendMail($message = 'ImportCommandController::sendMail()', $to = 'marc@klickfabrik.net')
    {
        $empfaenger = $to;
        $betreff = $this->mailSubject;
        $nachricht = $this->checkMessage($message);

        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";
        $header .= "From: {$this->mailFrom}" . "\r\n";
        $header .= 'X-Mailer: PHP/' . PHP_VERSION . "\r\n";

        mail($empfaenger, $betreff, $nachricht, $header);
    }

    /**
     * @param $message
     * @return string
     */
    private function checkMessage($message)
    {
        if (is_array($message)) {
            $message = $this->arrayToTable($message);
        }

        return $message;
    }

    /**
     * @param array $message
     * @return string
     */
    private function arrayToTable(array $message)
    {
        $table[] = '<table>';
        foreach ($message as $key => $value) {
            $table[] = '<tr>';
            if (!is_array($value)) {
                $table[] = '<td>';
                $table[] = "{$key}: {$value}";
                $table[] = '</td>';
            } else {
                $table[] = '<td>';
                if (!is_int($key))
                    $table[] = "<h3>{$key}</h3>";
                $table[] = $this->arrayToTable($value);
                $table[] = '</td>';
            }
            $table[] = '</tr>';
        }
        $table[] = '</table>';

        return implode("\n", $table);
    }
}

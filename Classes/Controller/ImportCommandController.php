<?php
namespace Klickfabrik\KfMobileDe\Controller;

/***
 *
 * This file is part of the "KF - Mobile.de" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Marc Finnern <typo3@klickfabrik.net>, Klickfabrik
 *
 ***/


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ImportCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * @var \Klickfabrik\KfMobileDe\Controller\ImporterController
     * @inject
     */
    protected $importService;

    private $mailFrom       = "";
    private $mailSubject    = "Typo3: ImporterController";


    /**
     * ImportCommandController constructor.
     */
    public function __construct() {
        $this->mailFrom = "typo3@" . $_SERVER['HTTP_HOST'];
    }

    /**
     * @param int $storageID
     * @param int $sendMail
     * @param string $to
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    public function ImportCommand($storageID = 0, $sendMail = 0, $to = "admin@typo3.de") {

        try {
            $res = $this->importService->runAutoImport(true,[
                "storageID" => $storageID,
                "tasks" => [
                    ["import" => 1],
                    ["status" => 1],
                    ["update_force" => 1],
                ]
            ]);
        } catch (Exception $e) {
            $res = sprintf("Exception abgefangen:%s\n", $e->getMessage());
        }

        if($sendMail){
            $this->sendMail($res,$to);
        }
    }

    /**
     * @param string $message
     * @param string $to
     */
    private function sendMail($message="ImportCommandController::sendMail()", $to = "marc@klickfabrik.net"){
        $empfaenger = $to;
        $betreff    = $this->mailSubject;
        $nachricht  = $this->checkMessage($message);

        $header  = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";
        $header .= "From: {$this->mailFrom}" . "\r\n";
        $header .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

        mail($empfaenger, $betreff, $nachricht, $header);
    }

    /**
     * @param $message
     * @return string
     */
    private function checkMessage($message){
        if(is_array($message)){
            $message = $this->arrayToTable($message);
        }

        return $message;
    }

    /**
     * @param array $message
     * @return string
     */
    function arrayToTable(array $message) {
        $table[] = "<table>";
        foreach ($message as $key => $value) {
            $table[] = "<tr>";
            if (!is_array($value)) {
                $table[] = "<td>";
                $table[] = "{$key}: {$value}";
                $table[] = "</td>";
            } else {
                $table[] = "<td>";
                if(!is_int($key))
                    $table[] = "<h3>{$key}</h3>";
                $table[] = $this->arrayToTable($value);
                $table[] = "</td>";
            }
            $table[] = "</tr>";
        }
        $table[] = "</table>";

        return join("\n", $table);
    }
}

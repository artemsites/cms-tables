<?php

namespace App\Service;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheetsService
{
    private $credentialsJson;

    public function __construct(string $credentialsJson)
    {
        $this->credentialsJson = $credentialsJson;
    }

    public function createClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName('CMS Sheets');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($this->credentialsJson);

        return $client;
    }
}
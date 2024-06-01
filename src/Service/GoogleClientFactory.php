<?php
namespace App\Service;

use Google_Client;

class GoogleClientFactory
{
    public static function createFromJson($credentialsJson, array $scopes): Google_Client
    {
        $client = new Google_Client();
        $client->setAuthConfig($credentialsJson);
        foreach ($scopes as $scope) {
            $client->addScope($scope);
        }
        $client->setAccessType('offline'); // Get a refresh token as well
        $client->setPrompt('select_account consent'); // Force consent screen to ensure we always get a refresh token

        return $client;
    }
}
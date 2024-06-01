<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;



class FetchService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchContentFromUrl(string $url): string
    {
        $response = $this->client->request('GET', $url);

        if ($response->getStatusCode() === 200) {
            return $response->getContent();
        } else {
            throw new \Exception('The page content could not be retrieved');
        }
    }
}
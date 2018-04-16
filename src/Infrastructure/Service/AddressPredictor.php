<?php

namespace App\Infrastructure\Service;

use GuzzleHttp\Client;

class AddressPredictor
{

    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param Client $client
     * @param string $apiKey
     */
    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * Calculates a price
     * @param string $searchString
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function autocomplete(string $searchString): string
    {
        $response = $this->client->request(
            'GET',
            'https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            "query" => [
                'input' => $searchString,
                'language' => 'ru',
                'key' => $this->apiKey

            ]
        ]);

        return $response->getBody()->getContents();
    }
}
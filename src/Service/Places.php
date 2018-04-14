<?php

namespace App\Service;
use GuzzleHttp\Client;

class Places
{
    /**
     * Calculates a price
     * @param string $searchString
     * @return string
     */
    public function generateAutocomplete(string $searchString)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            "query" => [
                'input' => $searchString,
                'language' => 'ru',
                'key' => 'AIzaSyDX4-hTcemB_2_IL-BR0YYgPHrHgx4Fjsw'

            ]
        ]);

        return $response->getBody()->getContents();
    }
}
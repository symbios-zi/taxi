<?php

namespace App\Service;
use App\Entity\Location;
use GuzzleHttp\Client;

class Places
{
    /**
     * Calculates a price
     * @param string $searchString
     * @return string
     */
    public function generateAutocomplete(string $searchString): string
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            'https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            "query" => [
                'input' => $searchString,
                'language' => 'ru',
                'key' => 'AIzaSyDX4-hTcemB_2_IL-BR0YYgPHrHgx4Fjsw'

            ]
        ]);

        return $response->getBody()->getContents();
    }


    /**
     * @param string $placeId
     * @return array
     */
    public function getDetailPlaceById(string $placeId): array
    {
        $client = new Client();

        $response = $client->request(
            'GET',
            'https://maps.googleapis.com/maps/api/place/details/json', [
            "query" => [
                'placeid' => $placeId,
                'language' => 'ru',
                'key' => 'AIzaSyDX4-hTcemB_2_IL-BR0YYgPHrHgx4Fjsw'

            ]
        ]);

        $formattedResponse = json_decode($response->getBody(), true);

        return [$formattedResponse["result"]["geometry"]["location"]["lat"],
                $formattedResponse["result"]["geometry"]["location"]["lng"]];
    }
}
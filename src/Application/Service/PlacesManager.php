<?php

namespace App\Application\Service;

use App\Domain\Entity\Route;
use App\Domain\Entity\Location;
use GuzzleHttp\Client;

class PlacesManager
{

    /**
     * @var Client
     */
    private $client;

    /**
     * PlacesManager constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    /**
     * Calculates a price
     * @param string $searchString
     * @return string
     */
    public function generateAutocomplete(string $searchString): string
    {
        $response = $this->client->request(
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
     * @return Location
     */
    public function getDetailPlaceById(string $placeId): Location
    {
        $response = $this->client->request(
            'GET',
            'https://maps.googleapis.com/maps/api/place/details/json', [
            "query" => [
                'placeid' => $placeId,
                'language' => 'ru',
                'key' => 'AIzaSyDX4-hTcemB_2_IL-BR0YYgPHrHgx4Fjsw'

            ]
        ]);

        $formattedResponse = json_decode($response->getBody(), true);

        return new Location(
            $formattedResponse["result"]["geometry"]["location"]["lat"],
            $formattedResponse["result"]["geometry"]["location"]["lng"]
        );
    }

    /**
     * @param Location $point
     * @param Location $destination
     * @return \App\Domain\Entity\Route
     */
    public function getRoute(Location $point, Location $destination): Route
    {
        $response = $this->client->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json', [
            "query" => [
                "origins" => $point->latitude().",".$point->longitude(),
                "destinations" => $destination->latitude().",".$destination->longitude(),
                "mode" => "driving",
                "language" => 'ru'
            ]
        ]);

        $decodedResponse = json_decode((string) $response->getBody()->getContents(), true);

        return $this->parseResponseToRouteValueObject($point, $destination, $decodedResponse);
    }

    /**
     * @param Location $point
     * @param Location $destination
     * @param $decodedResponse
     * @return mixed
     */
    public function parseResponseToRouteValueObject(Location $point, Location $destination, $decodedResponse)
    {
        $route = [
            "point" => $point,
            "destination" => $destination,
            "distance" => $decodedResponse["rows"][0]["elements"][0]["distance"]["value"],
            "duration" => $decodedResponse["rows"][0]["elements"][0]["duration"]["value"],
            "origin_address" => $decodedResponse["origin_addresses"][0],
            "destination_address" => $decodedResponse["destination_addresses"][0],
        ];

        return new Route(
            $point,
            $destination,
            $route["distance"],
            $route["duration"]
        );
    }
}
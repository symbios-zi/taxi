<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Route;
use App\Domain\Entity\Location;
use GuzzleHttp\ClientInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class RoutePlanner
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var string
     */
    private $apiKey;

    /**
     * PlacesManager constructor.
     * @param ClientInterface $client
     * @param string $apiKey
     */
    public function __construct(ClientInterface $client, string $apiKey)
    {

        $this->client = $client;
        $this->apiKey = $apiKey;
    }


    /**
     * @param array $places
     * @return Route
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function routeFor(array $places)
    {
        return $this->measure(
            $this->getDetailPlaceById($places[0]),
            $this->getDetailPlaceById($places[1])
        );
    }

    /**
     * @param string $placeId
     * @return Location
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getDetailPlaceById(string $placeId): Location
    {
        $response = $this->client->request(
            'GET',
            'https://maps.googleapis.com/maps/api/place/details/json', [
            "query" => [
                'placeid' => $placeId,
                'language' => 'ru',
                'key' => $this->apiKey

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function measure(Location $point, Location $destination): Route
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

        return $this->build($point, $destination, $decodedResponse);
    }

    /**
     * @param Location $point
     * @param Location $destination
     * @param $decodedResponse
     * @return Route
     */
    private function build(Location $point, Location $destination, $decodedResponse): Route
    {
        $route = [
            "point" => $point,
            "destination" => $destination,
            "distance" => $decodedResponse["rows"][0]["elements"][0]["distance"]["value"],
            "duration" => $decodedResponse["rows"][0]["elements"][0]["duration"]["value"],
            "origin_address" => $decodedResponse["origin_addresses"][0],
            "destination_address" => $decodedResponse["destination_addresses"][0],
        ];

        return new Route($point, $destination, $route["distance"], $route["duration"]);
    }
}
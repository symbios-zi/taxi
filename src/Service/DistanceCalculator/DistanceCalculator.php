<?php

namespace App\Service\DistanceCalculator;

use App\Entity\Location;
use App\Entity\Route;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;

class DistanceCalculator implements DistanceCalculatorInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * DistanceCalculator constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Location $point
     * @param Location $destination
     * @return \App\Entity\Route[]|array
     */
    public function getRoutes(Location $point, Location $destination): array
    {
        $client = new Client();

        $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json', [
            "query" => [
                "origins" => $point->latitude().",".$point->longitude(),
                "destinations" => $destination->latitude().",".$destination->longitude(),
                "mode" => "driving",
                "language" => $this->container->getParameter('locale')
            ]
        ]);

        $decodedResponse = json_decode((string) $response->getBody()->getContents(), true);
        $routes = $this->parseResponeToRouteValueObject($point, $destination, $decodedResponse);

        return $routes;
    }

    /**
     * @param Location $point
     * @param Location $destination
     * @param $decodedResponse
     * @return mixed
     */
    public function parseResponeToRouteValueObject(Location $point, Location $destination, $decodedResponse)
    {
        $routes = [];

        foreach ($decodedResponse["rows"] as $key => $row) {
            $routes[$key] = [
                "point" => $point,
                "destination" => $destination,
                "distance" => $row["elements"][0]["distance"]["value"],
                "duration" => $row["elements"][0]["duration"]["value"]
            ];
        }

        foreach ($decodedResponse["origin_addresses"] as $key => $address) {
            $routes[$key]["origin_address"] = $address;
        }

        foreach ($decodedResponse["destination_addresses"] as $key => $address) {
            $routes[$key]["destination_address"] = $address;
        }

        foreach ($routes as $route) {
            $collectionRoutes[] = new Route(
                $point,
                $destination,
                $route["distance"],
                $route["duration"]
            );
        }

        return $collectionRoutes;
    }
}
<?php

namespace App\Controller;

use App\Entity\Journey;
use App\Entity\Location;
use App\Service\DistanceCalculator\DistanceCalculator;
use App\Service\Places;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JourneyController extends Controller
{
    /**
     * @var DistanceCalculator
     */
    private $distanceCalculator;
    /**
     * @var Places
     */
    private $placesService;

    /**
     * JourneyController constructor.
     * @param DistanceCalculator $distanceCalculator
     * @param Places $placesService
     */
    public function __construct(DistanceCalculator $distanceCalculator, Places $placesService)
    {
        $this->distanceCalculator = $distanceCalculator;
        $this->placesService = $placesService;
    }

    /**
     * @Route("/journey", name="journey")
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $routes = $this->prepareRoutes($request);

        $journey = new Journey($routes);

        dump($journey); die();

        return new Response('Welcome to your new controller!');
    }

    /**
     * @param Request $request
     * @return \App\Entity\Route[]|array
     */
    public function prepareRoutes(Request $request)
    {
        $pointPlaceId = $request->get('from');
        $destinationPlaceId = $request->get('to');

        $point = $this->placesService->getDetailPlaceById($pointPlaceId);
        $destination = $this->placesService->getDetailPlaceById($destinationPlaceId);

        $routes = $this->distanceCalculator->getRoutes(
            new Location($point[0], $point[1]),
            new Location($destination[0], $destination[1])
        );
        return $routes;
    }


}

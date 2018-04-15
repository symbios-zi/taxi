<?php

namespace App\Presentation\Controller;

use App\Application\Service\PlacesManager;
use App\Application\Service\JourneyService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class JourneyController extends Controller
{
    /**
     * @var JourneyService
     */
    private $journeyService;

    /**
     * @var PlacesManager
     */
    private $placesManager;

    /**
     * JourneyController constructor.
     * @param JourneyService $journeyService
     * @param PlacesManager $placesManager
     */
    public function __construct(JourneyService $journeyService, PlacesManager $placesManager)
    {
        $this->journeyService = $journeyService;
        $this->placesManager = $placesManager;
    }

    /**
     * @Route("/journey", name="journey")
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $routes = $this->prepareRoutes($request);

        $journey = $this->journeyService->request($routes);

        dump($journey); die();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function prepareRoutes(Request $request)
    {
        $pointPlaceId = $request->get('from');
        $destinationPlaceId = $request->get('to');

        $point = $this->placesManager->getDetailPlaceById($pointPlaceId);
        $destination = $this->placesManager->getDetailPlaceById($destinationPlaceId);

        $routes[] = $this->placesManager->getRoute($point, $destination);

        return $routes;
    }


}

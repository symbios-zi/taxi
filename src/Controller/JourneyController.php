<?php

namespace App\Controller;

use App\Entity\Journey;
use App\Entity\Location;
use App\Service\DistanceCalculator\DistanceCalculator;
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
     * JourneyController constructor.
     * @param DistanceCalculator $distanceCalculator
     */
    public function __construct(DistanceCalculator $distanceCalculator)
    {
        $this->distanceCalculator = $distanceCalculator;
    }

    /**
     * @Route("/journey", name="journey")
     */
    public function index(Request $request)
    {
        $point = explode(',', $request->get('from'));
        $destination = explode(',', $request->get('to'));

        $routes =$this->distanceCalculator->getRoutes(
            new Location($point[0], $point[1]),
            new Location($destination[0], $destination[1])
        );


        $journey = new Journey($routes);

        return new Response('Welcome to your new controller!');
    }


}

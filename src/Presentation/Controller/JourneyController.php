<?php

namespace App\Presentation\Controller;

use App\Infrastructure\Service\RoutePlanner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class JourneyController extends Controller
{
    /**
     * @var RoutePlanner
     */
    private $routePlanner;

    /**
     * JourneyController constructor.
     * @param RoutePlanner $routePlanner
     */
    public function __construct(RoutePlanner $routePlanner)
    {
        $this->routePlanner = $routePlanner;
    }

    /**
     * @Route("/journey", name="journey")
     * @param Request $request
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(Request $request)
    {
        $points = [
            $request->get('from'),
            $request->get('to'),
        ];

        $route = $this->routePlanner->routeFor($points);
    }

}

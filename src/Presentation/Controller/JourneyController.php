<?php

namespace App\Presentation\Controller;

use App\Domain\Entity\EstimatedJourney;
use App\Infrastructure\Service\RoutePlanner;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(Request $request): Response
    {
        $points = [
            $request->get('from'),
            $request->get('to'),
        ];

        $routes[] = $this->routePlanner->routeFor($points);
        $estimatedJourney = new EstimatedJourney($routes);

        return $this->prepareResponse($estimatedJourney);
    }

    /**
     * @Route("/journey/order", name="journey-order")
     * @param Request $request
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order(Request $request): Response
    {
        $points = [
            $request->get('from'),
            $request->get('to'),
        ];

        $routes[] = $this->routePlanner->routeFor($points);
        dump($routes); die();
    }

    /**
     * @return Serializer
     */
    public function buildSerializer(): Serializer
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        return $serializer;
    }

    /**
     * @param $estimatedJourney
     * @return Response
     */
    private function prepareResponse($estimatedJourney): Response
    {
        $serializer = $this->buildSerializer();
        $jsonContent = $serializer->serialize($estimatedJourney, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}

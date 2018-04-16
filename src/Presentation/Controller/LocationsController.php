<?php

namespace App\Presentation\Controller;

use App\Infrastructure\Service\AddressPredictor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LocationsController extends Controller
{
    /**
     * @var AddressPredictor
     */
    private $addressPredictor;

    /**
     * LocationsController constructor.
     * @param AddressPredictor $addressPredictor
     */
    public function __construct(AddressPredictor $addressPredictor)
    {
        $this->addressPredictor = $addressPredictor;
    }

    /**
     * @Route("/api/v1/places/autocomplete", name="autocomplete-places")
     * @param Request $request
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $searchString = $request->get('q');
        $response = $this->addressPredictor->autocomplete($searchString);

        return new JsonResponse($response, 200, [], true);
    }
}

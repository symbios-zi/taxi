<?php

namespace App\Presentation\Controller;

use App\Application\Service\PlacesManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LocationsController extends Controller
{
    /**
     * @var PlacesManager
     */
    private $placesService;

    /**
     * LocationsController constructor.
     * @param $placesService
     */
    public function __construct(PlacesManager $placesService)
    {
        $this->placesService = $placesService;
    }

    /**
     * @Route("/api/v1/places/autocomplete", name="autocomplete-places")
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $searchString = $request->get('q');
        $response = $this->placesService->generateAutocomplete($searchString);

        return new JsonResponse($response, 200, [], true);
    }
}

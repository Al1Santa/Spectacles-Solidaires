<?php

namespace App\Controller\Api;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;



/**
 * @OA\Tag(name="Evenements")
 */
class EventController extends AbstractController
{
    /**
     * List all events 
     * 
     * @OA\Response(
     *     response=200,
     *     description="Display ll events",
    
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="event not found"
     * )
     * @param EventRepository $eventRepository
     * @Route("/api/event", name="app_api_event", methods={"GET"})
     */
    public function index(EventRepository $repo): Response
    {
        $allEvents = $repo->findAll();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/EventController.php',
            'events' => $allEvents
        ], 
         // The HTTP status code, 200
         Response::HTTP_OK,
         // HTTP headers, by default
        [],
        //// in the context, we specify the serialization groups
        // to limit the properties that we want serializer
        [
            "groups" => 
            [
                "show_event"
            ]
        ]);
    }
}

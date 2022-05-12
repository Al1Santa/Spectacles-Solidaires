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
     * Liste toutes les evenements 
     * 
     * @OA\Response(
     *     response=200,
     *     description="Affiches tous les evenements",
    
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="evenement not found"
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
         // le HTTP status code, 200
        Response::HTTP_OK,
        // les entetes HTTP, par défault
        [],
        // dans le context, on précise les groupes de sérialisation
        // pour limiter les propriétés que l'on veut serializer
        [
            "groups" => 
            [
                "show_event"
            ]
        ]);
    }
}

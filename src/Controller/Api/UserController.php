<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user", name="app_api_user")
     */
    public function index(UserRepository $repo): Response
    {
        $allUser = $repo->findAll();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/UserController.php',
             'users' => $allUser
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
                "show_user"
            ]
        ]
            
    );
    }
}

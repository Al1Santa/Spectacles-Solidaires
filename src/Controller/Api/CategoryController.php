<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{
    /**
     * Affiche les categories 
     * 
     * @OA\Response(
     *     response=200,
     *     description="Affiches toutes les categories",
    
     * )
     * 
     * @param CaterogyRepository $categoryRepository
     * @Route("/api/category", name="app_api_category", methods={"GET"})
     */
    public function index(CategoryRepository $repo): Response
    {
        $allCategories = $repo->findAll();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/CategoryController.php',
            'categories' => $allCategories
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
                "show_category"
            ]
        ]
    );
    }
}

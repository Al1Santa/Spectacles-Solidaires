<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryController extends AbstractController
{
    /**
     * Liste toutes les categories 
     * 
     * @OA\Response(
     *     response=200,
     *     description="Affiches toutes les categories",
    
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="Category not found"
     * )
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

    /**
     * Affiche les categories avec leur évènements
     * 
     * @Route("/api/category/event", name="app_api_category_event", methods={"GET"})
     * 
     * @OA\Response(
     *     response=200,
     *     description="Affichesles catégorie avec leur evenement",
    
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="Category not found"
     * )
     * @param CaterogyRepository $categoryRepository
     */
    public function Category(CategoryRepository $repo): Response
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
                "show_category_event"
            ]
        ]
    );
    }
}

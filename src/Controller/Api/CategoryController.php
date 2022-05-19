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


/**
 * @OA\Tag(name="Categories")
 */
class CategoryController extends AbstractController
{
    /**
     * list all categories
     * 
     * @OA\Response(
     *     response=200,
     *     description="display all categories",
    
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
        // The HTTP status code, 200
        Response::HTTP_OK,
        // HTTP headers, by default
        [],
        // in the context, we specify the serialization groups
        // to limit the properties that we want serializer
        [
            "groups" => 
            [
                "show_category"
            ]
        ]
    );
    }

    /**
     * Displya all categories with their events
     * 
     * @Route("/api/category/event", name="app_api_category_event", methods={"GET"})
     * 
     * @OA\Response(
     *     response=200,
     *     description="Displya all categories with their events",
    
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
        // The HTTP status code, 200
        Response::HTTP_OK,
        // HTTP headers, by default
        [],
        // in the context, we specify the serialization groups
        // to limit the properties that we want serializer
        [
            "groups" => 
            [
                "show_category_event"
            ]
        ]
    );
    }
}

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

      /**
     * Creation d'une catégorie
     * 
     * @Route("/api/category/create", name="app_api_category_create", methods={"POST"})
     * 
     * @OA\RequestBody(
     *     @Model(type=CategoryType::class)
     * )
     * 
     * @OA\Response(
     *     response=201,
     *     description="nouvelle catégorie crée",
     *     @OA\JsonContent(
     *          ref=@Model(type=Category::class, groups={"show_category"})
     *      )
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="Category not found"
     * )
     * 
     * @param Request $request infos venant de mon front/utilisateur
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializerInterface Permet de transformer du JSON en Objet
     * @return JsonResponse
     */
    public function create(
        Request $request,
        EntityManagerInterface $em,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validator
        ): JsonResponse
    {
        // TODO : Request parce que je vais recevoir des données
        $jsonContent = $request->getContent();
        // dump($jsonContent);
        // je transforme ces données en Entité
        //! la deserialisation ne respecte aucune règle (Assert sur notre entité)
        //? notre serializer peut faire des erreurs son notre front/utilisateur nous envoi du JSON mal formé
        try { // on espère que le serializerInterface arrive à relire le JSON
            $category = $serializerInterface->deserialize($jsonContent, Category::class, 'json');
        } catch(Exception $e){ 
            //  si le serializerInterface n'arrive pas à relire le JSON on saute directement dans la partie Catch
            
            // erreur 422 : on ne peut pas traiter les infos qu'ils nous a donné
            return $this->json(
                "JSON mal formé",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        

        
        // TODO : utiliser les Assert de notre entité pour valider la deserialisation
        // le validator nous renvoit la liste de toutes les erreurs
        $errorList = $validator->validate($category);

        //je teste si il y a des erreurs 
        if (count($errorList) > 0){
            // j'ai des erreurs, l'utilisateur/front n'a pas respecter les Assert
            //? version bourrine : je transforme le tableau en chaine
            $errors = (string) $errorList;

            // erreur 422 : on ne peut pas traiter les infos qu'ils nous a donné
            return $this->json(
                $errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // TODO : entityManagerInterface pour l'enregistrement
        $em->persist($category);
        $em->flush();
        // TODO : return json avec le bon code 201 (created)
        return $this->json(
            $category,
            // je précise que tout est OK de mon coté en précisant que la création c'est bien passé
            // 201
            Response::HTTP_CREATED,
            [],
            [
                "groups" => 
                [
                    "show_category"
                ]
            ]
        );
    }
}

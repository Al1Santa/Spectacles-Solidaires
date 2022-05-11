<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Examples\Polymorphism\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Form\UserType;

class UserController extends AbstractController
{
    /**
     * Liste toutes les utilisateurs
     * 
     * @OA\Response(
     *     response=200,
     *     description="Affiches tous les utilisateurs",
    
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="User not found"
     * )
     * @param UserRepository $userRepository
     * @Route("/api/user", name="app_api_user", methods={"GET"})
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

    /**
     * Création d'un utilisateur
     * 
     * @Route("/api/user", name="app_api_user", methods={"POST"})
     * 
     * @OA\RequestBody(
     *     @Model(type=UserType::class)
     * )
     * 
     * @OA\Response(
     *     response=201,
     *     description="new created user",
     *     @OA\JsonContent(
     *          ref=@Model(type=User::class, groups={"show_users"})
     *      )
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="User not found"
     * )
     * @param UserRepository $userRepository
     *
     * @param Request $request infos venant de mon front/utilisateur
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializerInterface Permet de transformer du JSON en Objet
     * @return JsonRespons
     */
    public function createItem(Request $request, SerializerInterface $serializer, EntityManagerInterface $doctrine, ValidatorInterface $validator)
    {
    // Récupérer le contenu JSON
    $jsonContent = $request->getContent();
    // Désérialiser (convertir) le JSON en entité Doctrine User
    $user = $serializer->deserialize($jsonContent, User::class, 'json');
    // Valider l'entité
    // @link : https://symfony.com/doc/current/validation.html#using-the-validator-service
    $errors = $validator->validate($user);
    // Y'a-t-il des erreurs ?
    if (count($errors) > 0) {
        // @todo Retourner des erreurs de validation propres
        return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    // On sauvegarde l'entité
    $doctrine->persist($user);
    $doctrine->flush();

    // on renvoit un code 201 et l'objet crée
    return $this->json($user, Response::HTTP_CREATED);
    }
}

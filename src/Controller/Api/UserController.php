<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Form\UserType;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @OA\Tag(name="User")
 */
class UserController extends AbstractController
{
    /**
     * Liste tous les utilisateurs
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
     * Crée un utilisateur
     * 
    * @Route("/api/user/create", name="app_api_user_create", methods={"POST"})
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
     * @param Request $request infos venant de mon front/utilisateur
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializerInterface Permet de transformer du JSON en Objet
     * @return JsonResponse
     */
    public function create(
        Request $request,
        EntityManagerInterface $em,
        SerializerInterface $serializerInterface,
        UserPasswordHasherInterface $hasher,
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
            $user = $serializerInterface->deserialize($jsonContent, User::class, 'json');
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
        $errorList = $validator->validate($user);

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
        $hashedPassword = $hasher->hashPassword($user);     
        $user->setPassword($hashedPassword);
        // TODO : entityManagerInterface pour l'enregistrement
        $em->persist($user);
        $em->flush();
        // TODO : return json avec le bon code 201 (created)
        return $this->json(
            $user,
            // je précise que tout est OK de mon coté en précisant que la cration c'est bien passé
            // 201
            Response::HTTP_CREATED,
            [],
            [
                "groups" => 
                [
                    "show_users"
                ]
            ]
        );
    }



    /**
     * Modifier les données utilisateur
     * 
     * @Route("/api/user/update/{id}", name="app_api_user_update", methods={"PUT"}, requirements={"id":"\d+"})
     * 
     * @OA\RequestBody(
     *     @Model(type=UserType::class)
     * )
     * 
     * @OA\Response(
     *     response=201,
     *     description="new update user",
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
    public function updateUser(int $id, Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $em, ValidatorInterface $validator, User $user, UserRepository $repo): JsonResponse
    {

        
     // TODO : Request parce que je vais recevoir des données
     $jsonContent = $request->getContent();

     $updatedUser = json_decode($jsonContent);
    

     $user = $repo->find($id);

     $user->setEmail($updatedUser->email);
     $user->setPassword($updatedUser->password);
     $user->setFirstName($updatedUser->firstname);
     $user->setLastName($updatedUser->lastname);
     $user->setAvatar($updatedUser->avatar);

     $em->flush();

     // TODO : return json avec le bon code 201 (created)
     return $this->json(
         $user,
         // je précise que tout est OK de mon coté en précisant que la cration c'est bien passé
         // 201
         Response::HTTP_CREATED,
         [],
         [
             "groups" => 
             [
                 "show_users"
             ]
         ]
     );
 }

 /**
     * Supprimer un utilisateur
     * @Route("/api/user/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id":"\d+"})
     * 
     * @OA\RequestBody(
     *     @Model(type=UserType::class)
     * )
     * 
     * @OA\Response(
     *     response=201,
     *     description="Delete user",
     *     @OA\JsonContent(
     *          ref=@Model(type=User::class, groups={"show_users"})
     *      )
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="User not found"
     * )
     * 
     * @param Request $request infos venant de mon front/utilisateur
     * @param EntityManagerInterface $em
     * @return JsonRespons
     */
    public function delete(int $id, Request $request, User $user, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        
    

        if ($user = $userRepository->find($id)) {
            $userRepository->remove($user);

     
            $em->flush();
        }
      

         // TODO : return json avec le bon code 201 (created)
     return $this->json(
        $user,
        // je précise que tout est OK de mon coté en précisant que la cration c'est bien passé
        // 201
        Response::HTTP_CREATED,
        [],
        [
            "groups" => 
            [
                "show_users"
            ]
            ]);
    }
}

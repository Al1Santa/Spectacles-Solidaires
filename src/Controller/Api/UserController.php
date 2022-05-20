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
     * List all users
     * 
     * @OA\Response(
     *     response=200,
     *     description="Display all users",
    
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
         // The HTTP status code, 200
         Response::HTTP_OK,
         // HTTP headers, by default
        [],
         // in the context, we specify the serialization groups
        // to limit the properties that we want serializer
        [
            "groups" => 
            [
                "show_user"
            ]
        ]
            
    );
    }

     /**
     * Récupérer les données d'un seul utilisateur
     * 
     * @OA\Response(
     *     response=200,
     *     description="Affiches les données d'un seul utilisateur ",
    
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="User not found"
     * )
     * @param UserRepository $userRepository
     * @Route("/api/user/{id}", name="app_api_one_user", methods={"GET"})
     */
    public function oneUser(int $id, UserRepository $repo): Response
    {
        $oneUser = $repo->find($id);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/UserController.php',
             'user' => $oneUser
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
     * Create user
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
     * @param Request $request info from my front/user
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializerInterface Allows you to transform JSON into an Object
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
        // TODO : Request because I will receive data
        $jsonContent = $request->getContent();
        // I transform this data into Entity
        //! the deserialization does not respect any rule (Assert on our entity)
        //? our serializer can make errors its our front/user sends us malformed JSON
        try { //   we hope that the serializerInterface manages to reread the JSON
            $user = $serializerInterface->deserialize($jsonContent, User::class, 'json');
            $plaintextPassword = $user->getPassword();
            $hashedPassword = $hasher->hashPassword($user, $plaintextPassword);     
            $user->setPassword($hashedPassword);

        } catch(Exception $e){ 
            //  if the serializerInterface cannot read the JSON again, we jump directly to the Catch part
            
            // error 422: we cannot process the information they gave us
            return $this->json(
                "JSON mal formé",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        
            
        // TODO : use the Asserts of our entity to validate the deserialization
        // the validator returns the list of all errors
        $errorList = $validator->validate($user);

        //I check if there are errors
        if (count($errorList) > 0){
            // I have errors, the user/front did not respect the Asserts
            //?bullshit version: I transform the array into a string
            $errors = (string) $errorList;

            // error 422: we cannot process the information they gave us
            return $this->json(
                $errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        // TODO : entityManagerInterface for save
        $em->persist($user);
        $em->flush();
        // TODO : return json with good code 201 (created)
        return $this->json(
            $user,
            // I specify that everything is OK on my side by specifying that the creation is well past
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
     * Modify user data
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
     * @param Request $request info from my front/user
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializerInterface Permet de transformer du JSON en Objet
     * @return JsonRespons
     */
    public function updateUser(int $id, Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $em, ValidatorInterface $validator, User $user, UserRepository $repo): JsonResponse
    {

        
     // TODO : Request because I will receive data
     $jsonContent = $request->getContent();

     $updatedUser = json_decode($jsonContent);
    

     $user = $repo->find($id);

     $user->setEmail($updatedUser->email);
     $user->setPassword($updatedUser->password);
     $user->setFirstName($updatedUser->firstname);
     $user->setLastName($updatedUser->lastname);
     $user->setAvatar($updatedUser->avatar);

     $em->flush();

     // TODO : return json with good code 201 (created)
     return $this->json(
         $user,
         // I specify that everything is OK on my side by specifying that the creation went well
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
     * Delete a user
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
     * @param Request $request info from my front/user
     * @param EntityManagerInterface $em
     * @return JsonRespons
     */
    public function delete(int $id, Request $request, User $user, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        
    

        if ($user = $userRepository->find($id)) {
            $userRepository->remove($user);

     
            $em->flush();
        }
      

         // TODO : return json with good code 201 (created)
     return $this->json(
        $user,
        // I specify that everything is OK on my side by specifying that the creation went well
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

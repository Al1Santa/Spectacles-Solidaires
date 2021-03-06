<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPassType;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/back/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       
            $plaintextPassword = $user->getPassword();

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $hasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

           
            $userRepository->add($user);

              // Add FlashMessage
            // @link https://symfony.com/doc/current/controller.html#flash-messages
            $this->addFlash(
                'notice', // the type of message is a key, so we can put whatever we want in it
                // we will be able to send several messages with the same type
                " L'utilisateur a bien été crée." // the message
            );

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserUpdateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);

                 // Add FlashMessage
            // @link https://symfony.com/doc/current/controller.html#flash-messages
            $this->addFlash(
                'notice', // the type of message is a key, so we can put whatever we want in it
                // we will be able to send several messages with the same type
                " L'utilisateur a bien été modifié." // the message
            );

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);

                 // Add FlashMessage
            // @link https://symfony.com/doc/current/controller.html#flash-messages
            $this->addFlash(
                'notice', // the type of message is a key, so we can put whatever we want in it
                // we will be able to send several messages with the same type
                " L'utilisateur a bien été supprimé." // the message
            );

        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/profil", name="app_user_profil", methods={"POST","GET"})
     */
    public function profil(int $id, UserRepository $userRepository): Response
    {
        return $this->render('user/profil.html.twig', [
            'user' => $userRepository->find($id),
        ]);
    }

        /**
     * @Route("/{id}/edit/profil", name="app_user_edit_profil", methods={"GET", "POST"})
     */
    public function editProfil(int $id, Request $request, User $user, UserRepository $userRepository): Response
    {
        $user =$userRepository->find($id);
        $form = $this->createForm(UserUpdateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
             // Add FlashMessage
                        // @link https://symfony.com/doc/current/controller.html#flash-messages
                        $this->addFlash(
                            'notice', // the type of message is a key, so we can put whatever we want in it
                            // we will be able to send several messages with the same types
                            " Le profil à bien été modifié." // the message
                        );
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit_profil.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit/password", name="app_user_edit_password", methods={"GET","POST"})
     */
    public function editPassword(int $id, UserRepository $userRepository, User $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserPassType::class, $user);
        $form->handleRequest($request);

        // We recover the original data thanks to getUntOfwork and getOriginalEntityData 
        $userDb = $em->getUnitOfwork()->getOriginalEntityData($user);

        //$userDb = $userRepository->find($id);
        // remember the original password
        $oldPassword = $userDb['password'];


        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $user->getPassword();

            // We first compare the new non-hash password with the old one which is hash
            // If they are identical then it is not good otherwise we modify the password
            if (password_verify($plaintextPassword, $oldPassword) )
            {
                        // Add FlashMessage
                        // @link https://symfony.com/doc/current/controller.html#flash-messages
                        $this->addFlash(
                            'notice', // the type of message is a key, so we can put whatever we want in it
                            // we will be able to send several messages with the same types
                            " Le mot de passe est identique, choissisez un autre mot de passe." // the message
                        );
                        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
               
            } else{
           
                //    Now that we have compared our two passwords we will be able to send the new password or not in the DB

                    // hash the password (based on the security.yaml config for the $user class)
                    $hashedPassword = $hasher->hashPassword(
                        $user,
                        $plaintextPassword
                    );
                

                    $user->setPassword($hashedPassword);
                    $userRepository->add($user);

                    // ajout d'un flash message
                    // @link https://symfony.com/doc/current/controller.html#flash-messages
                    $this->addFlash(
                        'notice', // the type of message is a key, so we can put whatever we want in it
                        // we will be able to send several messages with the same type
                        " Le mot de passe a été modifié." // the message
                    );

                    return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);  
            }
           
           
        }
                return $this->render('user/edit_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}

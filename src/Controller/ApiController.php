<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="app_api")
     */
    public function index(): Response
    {
        // return $this->render('api/index.html.twig', [
        //     'controller_name' => 'ApiController',
        // ]);

        //TODO: récupérer les données
        // $categoryModel = new Category();
        // $allCategory = $categoryModel->getAll
        //TODO: envoyé en json
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    // #[Route('/category', name: 'app_category')]
    // public function index(): Response
    // {
    //     return $this->render('category/index.html.twig', [
    //         'controller_name' => 'CategoryController',
    //     ]);
    // }

    #[Route('admin/category/create', name: 'category_create')]
    public function create(){



        return $this->render('category/create.html.twig');
    }

    #[Route('admin/category/{id}/edit')]
    public function edit(){


        return $this->render('category/edit.html.twig');
    }
}

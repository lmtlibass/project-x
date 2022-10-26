<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    //Afficher les produits par catégorie
    #[Route('/{slug}', name: 'product_category')]
    public function category($slug, CategoryRepository $categoryRepository): Response
    {   
        $category = $categoryRepository->findOneBy([
            'slug' => $slug
        ]);

        if(!$category){
            throw $this->createNotFoundException("La categorie n'existe pas");
        }

        return $this->render('product/category.html.twig', [
            'slug'      => $slug,
            'category'  => $category
        ]);
    }

    //Afficher les details d'un produit
    #[Route('/{category_slug}/{slug}', name: 'product_show')]
    public function show($slug, ProductRepository $productRepository){

        $product = $productRepository->findOneBy([
            'slug' => $slug
        ]);

        if(!$product){
            throw $this->createNotFoundException("Le produit n'éxiste pas");
        }

        return $this->render('product/show.html.twig', [
            'slug' => $slug,
            'product' => $product
        ]);

    }
}

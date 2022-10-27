<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    //Page ajouter un nouveau produit
    #[Route('/admin/product/create', name:'product_create')]
    public function create(FormFactoryInterface $factory, Request $request, SluggerInterface $sluggger, EntityManagerInterface $em){
        
        $builder = $factory->createBuilder(FormType::class);
   
        $form = $builder->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $product = $form->getData();
            $product->setSlug(strtolower($sluggger->slug($product->getName())));

            $em->persist($product);
            $em->flush();
            dd($product);
        }



        $formView = $form->createView();

        return $this->render('product/create.html.twig', [
            'formView' => $formView
        ]);
    }
}

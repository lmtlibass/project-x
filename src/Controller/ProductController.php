<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
    public function create(FormFactoryInterface $factory, Request $request){
        
        $builder = $factory->createBuilder();

        $builder->add('name', TextType::class, [
            'attr' => [
                'placeholder' => 'donner une couter description du produit'
            ]
            ])
            ->add('shortDescription', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'donner une couter description du produit'
                ]
            ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'placeholder' => 'donez le prix du produit'
                ]
            ])
            ->add('category', EntityType::class, [
                'attr' => [
                    'placeholder' => 'choisir une catégorie'
                ],
                'class'       => Category::class,
                'choice_label'=> 'name'
            ]);
        
        $form = $builder->getForm();

        //gerer les request (données saisies)
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $data = $form->getData();
        
            $product = new Product;
            $product->setName($data['name'])
                    ->setShortDescription($data['shortDescription'])
                    ->setPrice($data['price'])
                    ->setCategory($data['category']);
            dd($product);
        }



        $formView = $form->createView();

        return $this->render('product/create.html.twig', [
            'formView' => $formView
        ]);
    }
}

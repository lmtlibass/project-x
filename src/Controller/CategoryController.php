<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{
  

    #[Route('admin/category/create', name: 'category_create')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger){
        $form = $this->createForm(CategoryType::class);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $category = $form->getData();
            $category->setSlug(strtolower($slugger->slug($category->getName())));

            $em->persist($category);
            $em->flush();
            
            return $this->redirectToRoute('home');
        }

        $formView = $form->createView();

        return $this->render('category/create.html.twig', [
            'formView' => $formView 
        ]);
    }

    #[Route('admin/category/{id}/edit')]
    public function edit($id, CategoryRepository $categoryRepository){
        $category = $categoryRepository->find($id);

        return $this->render('category/edit.html.twig',[
            'category' => $category
        ]);
    }
}

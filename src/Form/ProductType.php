<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
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
            ->add('mainPicture', UrlType::class, [
                'attr' => [
                    'placeholder' => 'choisir une image'
                ]
            ])
            ->add('category', EntityType::class, [
                'attr' => [
                    'placeholder' => 'choisir une catégorie'
                ],
                'class'       => Category::class,
                'choice_label'=> 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

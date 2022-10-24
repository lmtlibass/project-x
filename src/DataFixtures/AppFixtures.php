<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use FakerEcommerce\Ecommerce;
use Bezhanov\Faker\Provider\Commerce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger){

        $this->slugger = $slugger;
    }
        
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new Ecommerce($faker));
        $faker->addProvider(new Commerce($faker));
       
        //créer trois catégories
        for($c = 0; $c < 3; $c++){
            $category = new Category;
            $category->setName($faker->category())
                    ->setSlug(strtolower($this->slugger->slug($category->getName())));
            
            $manager->persist($category);

            //enregistrer des produits rattaché à des catégories
            for ($p = 0; $p < mt_rand(15,20); $p++){
                $product = new Product;
                $product->setName($faker->watches())
                        ->setPrice(mt_rand(1000, 20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category);

                $manager->persist($product);       
            }
        }

        

        $manager->flush();
    }
}

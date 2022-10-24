<?php 
namespace App\Controller;

use Twig\Environment;
use App\Classes\Detector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HelloController extends AbstractController
{
   
    #[Route('hello/{prenom?inconu}') ]
    public function index(Request $request, $prenom, Environment $twig)
    {
        
        return $this->render('home.html.twig', [
            'prenom' => $prenom,
            'age'    => [
                12,
                18,
                29,
                15,
            ]   

        ]);
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home2')]
    public function index(): Response
    {
        $title="3A54";
        return $this->render('home/index2.html.twig', [
            'controller_name' => 'Accueil',
            't'=>$title,
        ]);
    }

    #[Route('/home/{nom}', name: 'app_home')]
    public function index2($nom):      Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home Controller!',
            'nom' => $nom
        ]);
    }

    #[Route('/redirect', name: "app_redirect")]
    public function rediriger(){
        return $this->redirectToRoute('app_msg');
    }

 #[Route('/msg', name: 'app_msg')]
 public function msg(){
    return new Response('Ceci est un message simple');
 }

}

<?php

namespace App\Controller\Base;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/about', name: 'page.about')]
    public function index(): Response
    {
        return $this->render('page/about.html.twig',);
    }


    #[Route('/politico', name: 'page.politico')]
    public function politico(): Response
    {
        return $this->render('page/politico.html.twig',);
    }
}

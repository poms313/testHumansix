<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/api/home", name="api_home")
     */
    public function index(): Response
    {
        return $this->render('api/home/index.html.twig', [
        ]);
    }
}

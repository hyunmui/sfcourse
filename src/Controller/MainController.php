<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * 
     * @Route("/custom/{name?}", name="custom")
     * @author Martin Seon
     * @param Request $request 
     * @return Response 
     */
    public function custom(Request $request, string $name): Response
    {
        return $this->render('home/custom.html.twig', [
            'name' => $name
        ]);
    }
}

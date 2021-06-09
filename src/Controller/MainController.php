<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return new Response('<h1>Welcome freeCodeCamp!</h1>');
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
        return new Response("<h1>Welcome {$name}!</h1>");
    }
}

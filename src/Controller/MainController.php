<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        return $this->json(["message", "prova"]);
    }

    /**
     * @Route("/custom/{name}", name="custom")
     */
    public function custom(Request $request): Response
    {
        dump($request);
         return $this->json(["message", $request->get("name")]);
        // return new Response('Hello wolr');
    }
}

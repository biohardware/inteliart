<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product")
     */
    public function index()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}

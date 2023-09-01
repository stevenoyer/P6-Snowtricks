<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/group/create', name: 'category_create', methods: ['POST', 'GET'])]
    public function index(): Response
    {
        // To do
        return $this->render('category/create.html.twig', []);
    }

    #[Route('/group/edit/{slug}', name: 'category_edit', methods: ['POST', 'GET'])]
    public function edit($slug): Response
    {
        // To do
        return $this->render('category/edit.html.twig', []);
    }
}

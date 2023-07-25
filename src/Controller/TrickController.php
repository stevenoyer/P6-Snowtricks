<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{

    #[Route('/tricks/create', name: 'trick_create')]
    public function create(): Response
    {
        // To do
        return $this->render('trick/create.html.twig', [
            
        ]);
    }

    #[Route('/tricks/details/{slug}', name: 'trick_show')]
    public function show($slug): Response
    {
        // To do
        return $this->render('trick/show.html.twig', [
            
        ]);
    }

    #[Route('/tricks/edit/{slug}', name: 'trick_edit')]
    public function edit($slug): Response
    {
        // To do
        return $this->render('trick/edit.html.twig', [
            
        ]);
    }
    
}

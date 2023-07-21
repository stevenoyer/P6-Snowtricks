<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'user_profile')]
    public function show(): Response
    {
        // To do
        return $this->render('user/profile.html.twig', [
            
        ]);
    }

    #[Route('/profile/edit', name: 'user_edit')]
    public function edit(): Response
    {
        // To do
        return $this->render('user/edit.html.twig', [
            
        ]);
    }

}

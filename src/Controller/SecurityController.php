<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security_login')]
    public function login(): Response
    {
        // To do
        return $this->render('security/login.html.twig', [
            
        ]);
    }

    #[Route('/register', name: 'security_register')]
    public function register(): Response
    {
        // To do
        return $this->render('security/register.html.twig', [
            
        ]);
    }

    #[Route('/reset/password', name: 'security_reset_password')]
    public function reset_password(): Response
    {
        // To do
        return $this->render('security/reset.html.twig', [
            
        ]);
    }
}

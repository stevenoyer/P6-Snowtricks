<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TrickRepository $trickRepository): Response
    {
        $items = $trickRepository->findBy(['state' => 1]);

        return $this->render('home/index.html.twig', [
            'items' => $items
        ]);
    }
}

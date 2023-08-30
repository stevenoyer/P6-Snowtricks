<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TrickRepository $trickRepository): Response
    {
        $items = $trickRepository->findBy(['state' => 1], ['createdAt' => 'DESC'], 9);

        return $this->render('home/index.html.twig', [
            'items' => $items,
            'count' => count($items)
        ]);
    }
}

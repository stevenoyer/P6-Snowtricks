<?php

namespace App\Controller;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {

        $faker = Factory::create();
        $items = [];

        for ($i = 0; $i < 9; $i++)
        {
            $items[] = [
                'title' => $faker->text(60),
                'description' => $faker->paragraph(1),
                'image' => 'https://picsum.photos/1800/1200'
            ];
        }

        return $this->render('home/index.html.twig', [
            'items' => $items
        ]);
    }
}

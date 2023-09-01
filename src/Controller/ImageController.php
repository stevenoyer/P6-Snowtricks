<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Service\FileDeleter;
use App\Service\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Delete a image
     */
    #[Route('/trick/{slug}/image/delete/{id}', name: 'trick_image_remove', methods: ['GET'])]
    public function remove($slug, $id): Response
    {

        $remove = $this->imageService->deleteImage($slug, $id);

        $this->addFlash($remove['type'], $remove['message']);
        return $this->redirectToRoute($remove['redirectRoute'], $remove['paramsRoute']);
    }

    /**
     * Updating the alternative text image
     */
    #[Route('/trick/{slug}/image/update/{id}', name: 'trick_image_update', methods: ['POST'])]
    public function update($slug, $id, Request $request)
    {

        $update = $this->imageService->updateAltImage($slug, $id, $request);

        $this->addFlash($update['type'], $update['message']);
        return $this->redirectToRoute($update['redirectRoute'], $update['paramsRoute']);
    }
}

<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Service\FileDeleter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{

    protected $imageRepository;
    protected $fileDeleter;
    protected $em;

    public function __construct(ImageRepository $imageRepository, FileDeleter $fileDeleter, EntityManagerInterface $em)
    {
        $this->imageRepository = $imageRepository;
        $this->fileDeleter = $fileDeleter;
        $this->em = $em;
    }

    #[Route('/trick/{slug}/image/delete/{id}', name: 'trick_image_remove')]
    public function remove($slug, $id): Response
    {
        $image = $this->imageRepository->find($id);
        if (!$image) {
            $this->addFlash('danger', 'No image found for delete.');
            return $this->redirectToRoute('trick_edit', ['slug' => $slug]);
        }

        $this->fileDeleter->delete($image->getName());

        $this->em->remove($image);
        $this->em->flush();

        $this->addFlash('success', 'Image has been successfully deleted.');
        return $this->redirectToRoute('trick_edit', ['slug' => $slug]);
    }

    #[Route('/trick/{slug}/image/update/{id}', name: 'trick_image_update', methods: 'POST')]
    public function update($slug, $id, Request $request)
    {
        $image = $this->imageRepository->find($id);
        if (!$image) {
            $this->addFlash('danger', 'No image found for update.');
            return $this->redirectToRoute('trick_edit', ['slug' => $slug]);
        }

        $image_alt = $request->request->get('image_alt');

        if (empty($image_alt)) {
            $this->addFlash('danger', 'Alternative text is empty.');
            return $this->redirectToRoute('trick_edit', ['slug' => $slug]);
        }

        $image->setAlt($image_alt);
        $this->em->flush();

        $this->addFlash('success', 'Alternative text has been successfully updated.');

        return $this->redirectToRoute('trick_edit', [
            'slug' => $slug
        ]);
    }
}

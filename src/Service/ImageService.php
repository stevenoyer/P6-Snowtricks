<?php

namespace App\Service;

use App\Service\FileDeleter;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;

class ImageService
{

    protected $imageRepository;
    protected $fileDeleter;
    protected $em;

    public function __construct(EntityManagerInterface $em, ImageRepository $imageRepository, FileDeleter $fileDeleter)
    {
        $this->imageRepository = $imageRepository;
        $this->fileDeleter = $fileDeleter;
        $this->em = $em;
    }

    /**
     * Delete a image
     */
    public function deleteImage($slug, $id)
    {
        $image = $this->imageRepository->find($id);

        if (!$image) {
            return [
                'type' => 'danger',
                'message' => 'No image found for delete.',
                'redirectRoute' => 'trick_edit',
                'paramsRoute' => ['slug' => $slug]
            ];
        }

        // Calls the fileDeleter service to delete the image
        $this->fileDeleter->delete($image->getName());

        $this->em->remove($image);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'Image has been successfully deleted.',
            'redirectRoute' => 'trick_edit',
            'paramsRoute' => ['slug' => $slug]
        ];
    }

    /**
     * Updating the alternative text image
     */
    public function updateAltImage($slug, $id, $image_alt): array
    {
        $image = $this->imageRepository->find($id);
        if (!$image) {
            return [
                'type' => 'danger',
                'message' => 'No image found for update.',
                'redirectRoute' => 'trick_edit',
                'paramsRoute' => ['slug' => $slug]
            ];
        }

        if (empty($image_alt)) {
            return [
                'type' => 'danger',
                'message' => 'Alternative text is empty.',
                'redirectRoute' => 'trick_edit',
                'paramsRoute' => ['slug' => $slug]
            ];
        }

        $image->setAlt($image_alt);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'Alternative text has been successfully updated.',
            'redirectRoute' => 'trick_edit',
            'paramsRoute' => ['slug' => $slug]
        ];
    }
}

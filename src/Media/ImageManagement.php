<?php

namespace App\Media;

use App\Entity\Image;
use App\Entity\Trick;
use App\Media\MediaManagement;
use App\Service\PictureUploader;
use Doctrine\ORM\EntityManagerInterface;

class ImageManagement extends MediaManagement
{
    protected $pictureUploader;
    protected $em;

    public function __construct(PictureUploader $pictureUploader, EntityManagerInterface $em)
    {
        $this->pictureUploader = $pictureUploader;
        $this->em = $em;
    }

    /**
     * This function lets you download images linked to a trick and save them in a database.
     */
    public function process(array $media, Trick $trick)
    {
        $files = $this->pictureUploader->process($media);

        foreach ($files as $file) {
            $image = new Image;
            $image->setName($file['filename']);
            $image->setAlt($file['alt']);
            $image->setTrick($trick);

            $this->em->persist($image);
        }
    }
}

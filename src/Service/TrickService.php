<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Trick;
use DateTimeImmutable;
use App\Media\ImageManagement;
use App\Media\VideoManagement;
use App\Service\PictureUploader;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickService
{

    protected $pictureUploader;
    protected $em;
    protected $slugger;
    protected $trickRepository;
    protected $imageManagement;
    protected $videoManagement;

    public function __construct(PictureUploader $pictureUploader, EntityManagerInterface $em, SluggerInterface $slugger, TrickRepository $trickRepository, ImageManagement $imageManagement, VideoManagement $videoManagement)
    {
        $this->pictureUploader = $pictureUploader;
        $this->em = $em;
        $this->slugger = $slugger;
        $this->trickRepository = $trickRepository;
        $this->imageManagement = $imageManagement;
        $this->videoManagement = $videoManagement;
    }

    /**
     * Create a trick
     */
    public function createTrick(Trick $trick, $form, User $user): array
    {
        $trick->setSlug(strtolower($this->slugger->slug($trick->getTitle())));
        $trick->setCreatedAt(new DateTimeImmutable('now'));
        $trick->setUpdateAt(new DateTimeImmutable('now'));

        // Main image processing via a service
        $mainPicture = $form->get('mainPicture')->getData();
        if (!empty($mainPicture)) {
            $trick->setMainPicture($this->pictureUploader->upload($mainPicture));
        }

        /* If there is no main picture, set the default main picture */
        if (empty($mainPicture)) {
            $trick->setMainPicture('snowtricks_header.jpeg');
        }

        $trick->setAuthor($user);

        // Processing images via a service
        $images = $form->getExtraData()['images'];
        if (!empty($images)) {
            $this->imageManagement->process($images, $trick);
        }

        // Processing videos via a service
        $videos = $form->getExtraData()['videos'];
        if (!empty($videos)) {
            $this->videoManagement->process($videos, $trick);
        }

        $this->em->persist($trick);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'The trick has been successfully created.',
            'redirectRoute' => 'home',
            'paramsRoute' => []
        ];
    }

    /**
     * Edit a trick
     */
    public function editTrick(Trick $trick, $form, User $user): array
    {
        $trick->setSlug(strtolower($this->slugger->slug($trick->getTitle())));
        $trick->setUpdateAt(new DateTimeImmutable('now'));

        // Main image processing via a service
        $mainPicture = $form->get('mainPicture')->getData();
        if (!empty($mainPicture)) {
            $trick->setMainPicture($this->pictureUploader->upload($mainPicture));
        }

        // Processing images via a service
        $images = $form->getExtraData()['images'];
        if (!empty($images)) {
            $this->imageManagement->process($images, $trick);
        }

        // Processing videos via a service
        $videos = $form->getExtraData()['videos'];
        if (!empty($videos)) {
            $this->videoManagement->process($videos, $trick);
        }

        $this->em->persist($trick);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'The trick has been successfully updated.',
            'redirectRoute' => 'home',
            'paramsRoute' => []
        ];
    }

    /**
     * Delete a trick
     */
    public function deleteTrick($trick): array
    {
        $this->em->remove($trick);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'The trick has been successfully deleted.',
            'redirectRoute' => 'home',
            'paramsRoute' => []
        ];
    }
}

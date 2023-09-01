<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    protected $videoRepository;
    protected $fileDeleter;
    protected $em;

    public function __construct(VideoRepository $videoRepository, EntityManagerInterface $em)
    {
        $this->videoRepository = $videoRepository;
        $this->em = $em;
    }

    #[Route('/trick/{slug}/video/delete/{id}', name: 'trick_video_remove', methods: ['GET'])]
    public function remove($slug, $id): Response
    {
        $video = $this->videoRepository->find($id);
        if (!$video) {
            $this->addFlash('danger', 'No video found for delete.');
            return $this->redirectToRoute('trick_edit', ['slug' => $slug]);
        }

        $this->addFlash('success', 'Video has been successfully deleted.');
        $this->em->remove($video);
        $this->em->flush();

        return $this->redirectToRoute('trick_edit', ['slug' => $slug]);
    }
}

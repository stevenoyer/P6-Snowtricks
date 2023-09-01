<?php

namespace App\Controller;

use App\Service\VideoService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * Delete a video
     */
    #[Route('/trick/{slug}/video/delete/{id}', name: 'trick_video_remove', methods: ['GET'])]
    public function remove($slug, $id): Response
    {
        $delete = $this->videoService->deleteVideo($slug, $id);

        $this->addFlash($delete['type'], $delete['message']);
        return $this->redirectToRoute($delete['redirectRoute'], $delete['paramsRoute']);
    }
}

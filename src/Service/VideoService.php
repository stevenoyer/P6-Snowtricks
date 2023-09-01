<?php

namespace App\Service;

use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;

class VideoService
{

    protected $videoRepository;
    protected $em;

    public function __construct(VideoRepository $videoRepository, EntityManagerInterface $em)
    {
        $this->videoRepository = $videoRepository;
        $this->em = $em;
    }

    /**
     * Delete a video
     */
    public function deleteVideo($slug, $id): array
    {
        $video = $this->videoRepository->find($id);
        if (!$video) {
            return [
                'type' => 'danger',
                'message' => 'No video found for delete.',
                'redirectRoute' => 'trick_edit',
                'paramsRoute' => ['slug' => $slug]
            ];
        }

        $this->em->remove($video);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'Video has been successfully deleted.',
            'redirectRoute' => 'trick_edit',
            'paramsRoute' => ['slug' => $slug]
        ];
    }
}

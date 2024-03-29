<?php

namespace App\Media;

use App\Entity\Trick;
use App\Entity\Video;
use App\Media\MediaManagement;
use Doctrine\ORM\EntityManagerInterface;

class VideoManagement extends MediaManagement
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * This function lets you save the videos attached to a trick in a database.
     */
    public function process(array $media, Trick $trick)
    {
        foreach ($media as $video) {
            $videoEntity = new Video;
            $videoEntity->setUrl($video);
            $videoEntity->setTrick($trick);

            $this->em->persist($videoEntity);
        }
    }
}

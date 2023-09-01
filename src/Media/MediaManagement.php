<?php

namespace App\Media;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;

abstract class MediaManagement
{
    abstract public function process(array $media, Trick $trick);
}

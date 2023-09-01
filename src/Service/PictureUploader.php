<?php

namespace App\Service;

use App\Service\FileUploader;

class PictureUploader extends FileUploader
{

    /**
     * This function returns a table with the name of the images and their alternative text
     */
    public function process(array $images)
    {
        $filenames = [];
        foreach ($images as $image) {
            if (empty($image['file'])) continue;

            $filenames[] = [
                'filename' => $this->upload($image['file']),
                'alt' => $image['alt']
            ];
        }

        return $filenames;
    }
}

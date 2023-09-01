<?php

namespace App\Service;

use App\Service\FileUploader;

class PictureUploader extends FileUploader
{

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

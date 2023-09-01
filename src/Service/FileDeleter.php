<?php

namespace App\Service;

class FileDeleter
{
    protected $picturesDirectory;

    public function __construct($picturesDirectory)
    {
        $this->picturesDirectory = $picturesDirectory;
    }

    /**
     * This function can be used to delete a file by name
     */
    public function delete($filename)
    {
        $file = $this->picturesDirectory . $filename;

        if (file_exists($file)) {
            unlink($file);
        }

        return false;
    }
}

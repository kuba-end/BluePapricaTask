<?php

namespace App\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageUploaderInterface
{
    public function upload(UploadedFile $file): string;

    public function getTargetDirectory(): string;
}

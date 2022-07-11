<?php

declare(strict_types=1);

namespace App\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageUploaderInterface
{
    public function upload(UploadedFile $file): string;

    public function getTargetDirectory(): string;
}

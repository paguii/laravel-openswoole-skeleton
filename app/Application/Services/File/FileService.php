<?php

namespace App\Application\Services\File;

use App\Domain\Repositories\FileRepositoryInterface;
use App\Infrastructure\Persistence\CloudinaryRepository;
use App\Infrastructure\Persistence\LocalFileRepository;

class FileService
{
    const FOLDERS = [
        'output' => 'output',
        'template' => 'template',
        'user' => 'user',
    ];

    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public static function build(): self
    {
        if (env('APP_ENV') === 'local') {
            return new self(new LocalFileRepository());
        }

        return new self(new CloudinaryRepository());
    }

    public function upload(string $filePath, string $folder): string
    {
        return $this->fileRepository->upload($filePath, $folder);
    }
}

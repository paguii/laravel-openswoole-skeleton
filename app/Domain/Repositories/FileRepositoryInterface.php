<?php

namespace App\Domain\Repositories;

interface FileRepositoryInterface
{
    public function upload(string $filePath, string $folder): string;
}

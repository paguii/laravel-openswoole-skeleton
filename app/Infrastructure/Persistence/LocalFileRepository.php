<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Repositories\FileRepositoryInterface;

class LocalFileRepository implements FileRepositoryInterface
{
    /**
     * Upload a file to the local filesystem.
     * 
     * @param string $filePath
     * @param string $folder
     * 
     * @return string
     */
    public function upload(string $filePath, string $folder): string
    {
        $destinationPath = sys_get_temp_dir() . '/' . $folder;
        
        $fileName = basename($filePath);
        $newFilePath = $destinationPath . '/' . $fileName;

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        copy($filePath, $newFilePath);

        return route('downloadPost', ['file_name' => $fileName]);
    }
}

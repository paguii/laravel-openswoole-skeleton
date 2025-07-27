<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Repositories\FileRepositoryInterface;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class CloudinaryRepository implements FileRepositoryInterface
{
    private Configuration $configuration;

    public function __construct()
    {
       $this->configuration = Configuration::instance(env('CLOUDINARY_URL'));
    }

    /**
     * Upload a file to Cloudinary.
     * 
     * @param string $filePath
     * @param string $folder
     * 
     * @return string
     */
    public function upload(string $filePath, string $folder): string
    {
        $uploadApi = new UploadApi($this->configuration);

        $response = $uploadApi->upload($filePath, [
            'folder' => $folder,
            'overwrite' => true,
            'resource_type' => 'auto',
        ]);

        return $response['secure_url'];
    }
}
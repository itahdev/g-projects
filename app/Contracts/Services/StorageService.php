<?php

namespace App\Contracts\Services;

interface StorageService
{
    /**
     * Get image url.
     *
     * @param string $name
     * @return string
     */
    public function getImageUrl(string $name): string;

    /**
     * Get temporary url of image on AWS S3.
     *
     * @param string $name File name.
     * @return string
     */
    public function getS3TemporaryUrl(string $name): string;

    /**
     * Upload file.
     *
     * @param object $file File object.
     * @param string $path Storage path.
     * @param string $name Name file.
     * @return string|null
     */
    public function uploadFile(object $file, string $path, string $name = ''): ?string;

    /**
     * Delete file.
     *
     * @param string $name File name.
     * @return bool
     */
    public function deleteFile(string $name): bool;
}

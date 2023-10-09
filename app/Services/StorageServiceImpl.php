<?php

namespace App\Services;

use App\Contracts\Services\StorageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class StorageServiceImpl implements StorageService
{
    /**
     * Get image url.
     *
     * @param string $name File name.
     * @return string
     */
    public function getImageUrl(string $name): string
    {
        return Storage::url($name);
    }

    /**
     * Get temporary url of image on AWS S3.
     *
     * @param string $name File name.
     * @return string
     */
    public function getS3TemporaryUrl(string $name): string
    {
        return Storage::temporaryUrl($name, Carbon::now()->addMinutes(30));
    }

    /**
     * Upload file.
     *
     * @param object $file File object.
     * @param string $path Storage path.
     * @param string $name Name file.
     * @return string|null
     */
    public function uploadFile(object $file, string $path, string $name = ''): ?string
    {
        try {
            $dataInfo = $this->getFileInfo($file);
            $dataInfo['path'] = $path;
            $dataInfo['name'] = $this->getFileName($file, $name);
            $filePath = sprintf('%s/%s', $dataInfo['path'], $dataInfo['name']);

            /** @phpstan-ignore-next-line */
            $fileContent = file_get_contents($file);
            if (!$fileContent) {
                throw new RuntimeException('The file is invalid.');
            }

            Storage::put($filePath, $fileContent);

            return $filePath;
        } catch (\Exception $e) {
            Log::error('[ERROR_UPLOAD_FILE] =>' . $e->getMessage());

            return null;
        }
    }

    /**
     * Get file name.
     *
     * @param object $file File object.
     * @param string $name Name file.
     * @return string
     */
    private function getFileName(object $file, string $name = ''): string
    {
        if (!$name) {
            $extension = $file->getClientOriginalExtension();
            $name = Str::replace(search: ".$extension", replace: '', subject: $file->getClientOriginalName());
        }

        return $name;
    }

    /**
     * Get file info.
     *
     * @param object $file File object.
     * @return array
     */
    private function getFileInfo(object $file): array
    {
        /** @phpstan-ignore-next-line */
        $imageSize = getimagesize($file);
        $size = null;
        if ($imageSize) {
            $size = $imageSize[0] . 'x' . $imageSize[1];
        }

        return [
            'size' => $size,
            'type' => $file->getClientOriginalExtension()
        ];
    }

    /**
     * Delete file.
     *
     * @param string $name File name.
     * @return bool
     */
    public function deleteFile(string $name): bool
    {
        try {
            $key = Storage::url($name);

            return Storage::delete($key);
        } catch (\Exception $e) {
            Log::error('[ERROR_DELETE_FILE] =>' . $e->getMessage());

            return false;
        }
    }
}

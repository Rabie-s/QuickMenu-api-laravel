<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait FileProcessingTrait
{
    /**
     * Get file contents.
     *
     * @param string $filename
     * @param string $directory
     * @param string|null $disk
     * @return string
     */
    public function getFile(string $filename, string $directory = 'uploads', string $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        $filePath = $directory . '/' . $filename;

        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->get($filePath);
        }

        return "File not found";
    }

    /**
     * Upload a single file.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $disk
     * @return string The uploaded file name
     */
    public function uploadFile(UploadedFile $file, string $directory = 'uploads', string $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        $file->storeAs($directory, $filename, $disk);

        return $filename;
    }

    /**
     * Upload multiple files.
     *
     * @param array $files
     * @param string $directory
     * @param string|null $disk
     * @return array List of uploaded file names
     */
    public function uploadFiles(array $files, string $directory = 'uploads', string $disk = null): array
    {
        $filenames = [];
        foreach ($files as $file) {
            $filenames[] = $this->uploadFile($file, $directory, $disk);
        }
        return $filenames;
    }

    /**
     * Delete a single file.
     *
     * @param string $filename
     * @param string $directory
     * @param string|null $disk
     * @return void
     */
    public function deleteFile(string $filename, string $directory = 'uploads', string $disk = null): void
    {
        $disk = $disk ?? config('filesystems.default');
        Storage::disk($disk)->delete($directory . '/' . $filename);
    }

    /**
     * Delete multiple files.
     *
     * @param array $filenames
     * @param string $directory
     * @param string|null $disk
     * @return void
     */
    public function deleteFiles(array $filenames, string $directory = 'uploads', string $disk = null): void
    {
        foreach ($filenames as $filename) {
            $this->deleteFile($filename, $directory, $disk);
        }
    }
}

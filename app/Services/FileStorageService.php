<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileStorageService
{

    public function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        return Storage::disk('s3')->put($folder, $file);
    }

    public function delete(string $path): bool
    {
        return Storage::disk('s3')->delete($path);
    }

    public function uploadAll(array $files, Model $model, string $folder = 'uploads' )
    {
        
        foreach ($files as $file) {
            $path = $this->upload($file, $folder);
            $model->files()->create(['path' => $path]);
        }

    }

    public function deleteAll(array $paths)
    {
        foreach ($paths as $path) {
            $this->delete($path['path']); 
        }
    }
}

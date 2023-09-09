<?php
namespace App\Trait;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

Trait File {
    public function storeFile(UploadedFile $file): string
    {
        $randomName = uniqid() . date('iHs');
        $extension = $file->getClientOriginalExtension();
        $fileName = $randomName . '.' . $extension;

        $file->storeAs('/files', $fileName, 'public');

        return $fileName;
    }

    public function replaceFile(UploadedFile $file, string $oldFile): string
    {
        $this->deleteFile($oldFile);

        return $this->storeFile($file);
    }

    public function deleteFile(string $fileName)
    {
        if (Storage::disk('public')->exists('files/' . $fileName))
            Storage::disk('public')->delete('files/' . $fileName);
    }
}
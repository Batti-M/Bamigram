<?php 

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function handleImageUpload($imageFile, $width = 400, $height = 400)
    {
        $image = Image::make($imageFile)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        $path = config('filesystems.disks.public.root') . '/images' . '/' . $imageFile->hashName();
        $image->save($path);

        return '/images/' . $imageFile->hashName();
    }
}
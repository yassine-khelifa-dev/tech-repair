<?php

namespace App\Services;



class FileUploadService
{
    public function storeImages($images, string $folder, $disk='public'){
        $paths = [];
        foreach ($images as $image) {
            $path = $image->store( $folder, $disk);
            $paths[] = ['path' => $path];
        }
       return $paths;
    }

  
}

<?php

namespace App\Services;



class FileUploadService
{
    public function storegeImages($images, $folder, $disk='public'){
        $paths = [];
        foreach ($images as $image) {
            $path = $image->store( $folder, $disk);
            $paths[] = ['path' => $path];
        }
       return $paths;
    }

    public function getImages(array $path){

    }
}

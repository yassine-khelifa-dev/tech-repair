<?php

namespace App\Services\Repair;

use App\Models\RepairRequest;
use App\Services\FileUploadService;

class RepairRequestService
{

    public function __construct(
        public FileUploadService $file_upload_service
    ) {
    }

    public function insert(array $data): RepairRequest
    {
        $data['images_device_path'] =
            $this->file_upload_service->storegeImages($data['images_device'], 'repair-devices');

        return  RepairRequest::create(
            [
                'data' =>  json_encode($data),
                // status: default:pending
            ]
        );
    }
}

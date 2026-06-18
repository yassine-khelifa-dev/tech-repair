<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\Device\BrandResource;
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Get all available brands.
     *
     * A Brand represents a device manufacturer.
     *
     * Examples:
     * - Apple
     * - Samsung
     * - Xiaomi
     * - Oppo
     *
     * A Brand can own multiple Device Models.
     *
     * This endpoint is used to populate brand selection lists
     * when creating a repair request.
     */

    public function index()
    {
        return BrandResource::collection(Brand::all());
    }
}

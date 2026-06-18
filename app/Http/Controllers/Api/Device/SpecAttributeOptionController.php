<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\Device\SpecAttributeOptionResource;
use App\Models\SpecAttributeOption;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\ExcludeRouteFromDocs;

class SpecAttributeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[ExcludeRouteFromDocs]
    public function index()
    {
        $_options = SpecAttributeOption::with('specAttribute')->get();
        return SpecAttributeOptionResource::collection($_options);
    }
}

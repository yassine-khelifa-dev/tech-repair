<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\Device\SpecAttributeResource;
use App\Models\SpecAttribute;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\ExcludeRouteFromDocs;
class SpecAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[ExcludeRouteFromDocs]
    public function index()
    {
        $_attributes = SpecAttribute::with('specOptions')->get();
        return SpecAttributeResource::collection( $_attributes );
    }


}

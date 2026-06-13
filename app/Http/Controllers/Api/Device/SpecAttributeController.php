<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\Device\SpecAttributeResource;
use App\Models\SpecAttribute;
use Illuminate\Http\Request;

class SpecAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $_attributes = SpecAttribute::with('specOptions')->get();
        return SpecAttributeResource::collection( $_attributes );
    }


}

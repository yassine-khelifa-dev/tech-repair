<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\Device\SpecAttributeOptionResource;
use App\Models\SpecAttributeOption;
use Illuminate\Http\Request;

class SpecAttributeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $_options = SpecAttributeOption::with('specAttribute')->get();
        return SpecAttributeOptionResource::collection( $_options );
    }


}


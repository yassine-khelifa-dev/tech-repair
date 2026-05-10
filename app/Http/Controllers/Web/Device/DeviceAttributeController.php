<?php

namespace App\Http\Controllers\Web\Device;

use App\Models\DeviceAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DeviceAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('device.attribute.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DeviceAttribute $deviceAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceAttribute $deviceAttribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceAttribute $deviceAttribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceAttribute $deviceAttribute)
    {
        //
    }
}

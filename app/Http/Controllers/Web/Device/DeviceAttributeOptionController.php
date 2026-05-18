<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceAttributeOptionRequest;
use App\Models\DeviceAttribute;
use App\Models\DeviceAttributeOption;
use Illuminate\Http\Request;

class DeviceAttributeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attr_options = DeviceAttributeOption::with('deviceAttribute.type')
                ->orderBy('device_attribute_id')
                ->get()
                ->groupBy('device_attribute_id');


       // return response()->json($attr_options);

        return view('device.option.index', compact('attr_options'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deviceAttributes = DeviceAttribute::with(['type', 'options'])->get();
        return view('device.option.create', compact('deviceAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceAttributeOptionRequest $request)
    {
       $data = $request->validated();

       DeviceAttributeOption::create( $data );

       return redirect()->route('device-attribute-option.index')
       ->with('success', 'a Device Attribute Option has bene craeted');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

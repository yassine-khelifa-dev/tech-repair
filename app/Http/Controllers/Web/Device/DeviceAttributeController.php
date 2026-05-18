<?php

namespace App\Http\Controllers\Web\Device;

use App\Models\DeviceAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceAttributeRequest;
use App\Http\Requests\Device\UpdateDeviceAttributeRequest;
use App\Models\Brand;
use App\Models\DeviceType;

class DeviceAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $device_attributes = DeviceAttribute::with('type')
                                        ->orderBy('device_type_id')
                                        ->orderBy('sort_order')
                                        ->latest()->paginate(4);
        return view('device.attribute.index', compact('device_attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devicetypes = DeviceType::all();
        $brands = Brand::all();
        return view('device.attribute.create', compact('devicetypes', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceAttributeRequest $request)
    {
      //  dd($request->all() , $request->boolean('is_filterable'), $request->boolean('is_required'));

        $data = $request->validated();

        $data['is_filterable'] = $request->boolean('is_filterable') ;
        $data['is_required']     = $request->boolean('is_required');


        DeviceAttribute::create( $data );

       if( $request->action == "save")
            return redirect()->route('device-attribute.index')->with('success', 'a Device Attribute has bene craeted');

        return redirect()->route('device-attribute.create')->with('success', 'a Device Attribute has bene craeted');
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
    public function edit(DeviceAttribute $device_attribute)
    {
                $devicetypes = DeviceType::all();

        return view('device.attribute.edit', compact('device_attribute', 'devicetypes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceAttributeRequest $request, DeviceAttribute $device_attribute)
    {
        // dd($request->all( ) );

        $data = $request->validated();
        $data['is_filterable'] = $request->boolean('is_filterable');
        $data['is_required']   = $request->boolean('is_required');

        $device_attribute->fill($data);

        if (! $device_attribute->isDirty()) {
            return redirect()
                ->route('device-attribute.index')
                ->with('info', 'No changes detected');
        }

        $device_attribute->save();

        return redirect()
            ->route('device-attribute.index')
            ->with('success', 'Device attribute updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceAttribute $device_attribute)
    {
        $device_attribute->delete();
        return redirect()->route('device-attribute.index')->with('success', 'Device Attribute has bene deleted');

    }
}

<?php

namespace App\Http\Controllers\Web\Device;

use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceTypeRequest;
use App\Http\Requests\Device\UpdateDeviceTypeRequest;

class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devicetypes = DeviceType::latest()->paginate(10);

        return view('device.type.index', [
            "devicetypes" => $devicetypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('device.type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceTypeRequest $request)
    {
        $deviceType = $request->validated();
        $deviceType['slug'] = Str::slug($deviceType['name']);

        DeviceType::create($deviceType);

        return redirect()->route('devicetype.index')->with('success', 'Device category has been created.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceType $devicetype)
    {
        return view('device.type.edit', ['devicetype' => $devicetype]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceTypeRequest $request, DeviceType $devicetype)
    {
        $data = $request->validated([]);

        $devicetype->update($data);

        if ($devicetype->wasChanged())
            return redirect()->route('devicetype.index')->with('success', 'Device category has been updated.');
        else
            return redirect()->route('devicetype.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceType $devicetype)
    {

        $devicetype->delete();

        return redirect()->route('devicetype.index')->with('success', 'Device category has been deleted.');
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\StoreDeviceTypeRequest;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devicetypes = DeviceType::all();

        return view('devicetype.index', [
         "devicetypes" => $devicetypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('devicetype.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceTypeRequest $request)
    {
        $deviceType = $request->validated();
        $deviceType['slug'] = Str::slug($deviceType['name']);

        DeviceType::create( $deviceType );

        return redirect()->route('devicetype.index')->with('success', 'a Device Type has bene craeted');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceType $devicetype)
    {
        return view('devicetype.edit', ['devicetype' => $devicetype]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceType $devicetype)
    {
         $data = $request->validate([
            'name' => 'required|min:3|max:255|unique:device_types,name,' . $devicetype->id,
        ]);

        $devicetype->update( $data );

        if($devicetype->wasChanged())
            return redirect()->route('devicetype.index')->with('success', 'device type has bene updated');
        else
            return redirect()->route('devicetype.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceType $devicetype)
    {

        $devicetype->delete();

        return redirect()->route('devicetype.index')->with('success', 'Device Type has bene deleted');
    }
}

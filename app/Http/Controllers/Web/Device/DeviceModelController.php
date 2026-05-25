<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceModelRequest;
use App\Http\Requests\Device\UpdateDeviceModelRequest;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use Illuminate\Support\Str;


class DeviceModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devicemodels = DeviceModel::with(['brand', 'type' ])->latest()->paginate(5);

        return view('device.model.index', [
             "devicemodels" => $devicemodels
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devicetypes = DeviceType::all();
        $brands = Brand::all();
        return view('device.model.create', compact('devicetypes', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceModelRequest $request)
    {
        $devicemodel = $request->validated();
        $devicemodel['slug'] = Str::slug($devicemodel['name']);

        DeviceModel::create( $devicemodel );

        if( $request->action == "save")
            return redirect()->route('devicemodel.index')->with('success', 'a Device Model has bene craeted');

        return redirect()->route('devicemodel.create')->with('success', 'a Device Model has bene craeted');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeviceModel $deviceModel)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceModel $devicemodel)
    {
        $devicemodel->load(['type', 'brand']);
        $brands = Brand::all();
        $devicetypes = DeviceType::all();

        return view('device.model.edit', compact('devicemodel', 'brands', 'devicetypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceModelRequest $request, DeviceModel $devicemodel)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $devicemodel->update( $data );

        if($devicemodel->wasChanged())
            return redirect()->route('devicemodel.index')->with('success', 'device model has bene updated');
        else
            return redirect()->route('devicemodel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceModel $devicemodel)
    {
        $devicemodel->delete();
        return redirect()->route('devicemodel.index')->with('success', 'Device Model has bene deleted');
    }
}

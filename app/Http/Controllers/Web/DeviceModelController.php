<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceModelRequest;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DeviceModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devicemodels = DeviceModel::with(['brand', 'type' ])->get();

        return view('devicemodel.index', [
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
        return view('devicemodel.create', compact('devicetypes', 'brands'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceModel $deviceModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceModel $deviceModel)
    {
        //
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

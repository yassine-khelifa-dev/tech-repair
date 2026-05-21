<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreSpecAttributeRequest;
use App\Models\DeviceType;
use App\Models\SpecAttribute;
use Illuminate\Http\Request;

class SpecAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("device.spec-attributes.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devicetypes = DeviceType::all();
        return view('device.spec-attributes.create', compact('devicetypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecAttributeRequest $request)
    {
       $data = $request->validated();
         $data['is_filterable'] = $request->boolean('is_filterable') ;
        $data['is_required']     = $request->boolean('is_required');

       dd($data);
       //SpecAttribute::create( $data );
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

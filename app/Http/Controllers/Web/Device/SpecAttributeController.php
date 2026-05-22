<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreSpecAttributeRequest;
use App\Http\Requests\Device\UpdateSpecAttributeRequest;
use App\Models\DeviceType;
use App\Models\SpecAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SpecAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spc_attributes = SpecAttribute::with(['specOptions', 'deviceTypes'])->get();
        return view("device.spec-attributes.index", compact('spc_attributes'));
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
        $data['is_filterable'] = $request->boolean('is_filterable');
        $data['is_required']     = $request->boolean('is_required');


        DB::transaction(function ()  use ($data) {
            // dd(  $data['devicetypes'] );
            /** @var SpecAttribute::class */
            $row_attr =  SpecAttribute::create($data);


            $spec_options =  collect($data['spec_options'])
                ->map(
                    fn($v, $i)  =>
                    [
                        'value' => strtolower(str_replace(' ', '_', $v)),
                        'label' => $v,
                        'sort_order' => $i,
                        'is_active' => 1,
                        'spec_attribute_id' => $row_attr->id,
                    ]
                )->values()
                ->toArray();

            if (! empty($spec_options))
                $row_attr->specOptions()->createMany($spec_options);

            $row_attr->deviceTypes()->sync($data['devicetypes']  ?? []);
        });


        //$spec_attr =  SpecAttribute::create( $data );
        return redirect()->route('spec-attribute.index')
            ->with('success', 'a  Attribute with  Option has bene craeted');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Alpine , using modal
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecAttribute $spec_attribute)
    {
        $devicetypes = DeviceType::all();

        $spec_attribute->load('specOptions', 'deviceTypes');

        return view("device.spec-attributes.edit", compact('spec_attribute', 'devicetypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecAttributeRequest $request, SpecAttribute $spec_attribute)
    {
        //  dd( $request->all());

        $data = $request->validated();
        $data['is_filterable'] = $request->boolean('is_filterable');
        $data['is_required']     = $request->boolean('is_required');


        DB::transaction(function ()  use ($data, $spec_attribute) {
            // dd(  $data['devicetypes'] );
            /** @var SpecAttribute::class */
            $spec_attribute->update($data);


            $spec_options =  collect($data['spec_options'])
                ->map(
                    fn($v, $i)  =>
                    [
                        'value' => strtolower(str_replace(' ', '_', $v)),
                        'label' => $v,
                        'sort_order' => $i,
                        'is_active' => 1,
                        'spec_attribute_id' => $spec_attribute->id,
                    ]
                )->values()
                ->toArray();

            if (! empty($spec_options)) {
                $spec_attribute->specOptions()->delete();
                $spec_attribute->specOptions()->createMany($spec_options);
            }

            $spec_attribute->deviceTypes()->sync($data['devicetypes']  ?? []);
        });


        //$spec_attr =  SpecAttribute::create( $data );
        return redirect()->route('spec-attribute.index')
            ->with('success', 'a  Attribute with  Option has bene updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpecAttribute $spec_attribute)
    {

        DB::transaction(function () use ($spec_attribute) {

            $spec_attribute->deviceTypes()->detach();

            $spec_attribute->delete();
        });

        return redirect()
            ->route('spec-attribute.index')
            ->with('success', 'Attribute deleted successfully.');
    }
}

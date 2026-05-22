<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreSpecAttributeRequest;
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
            $spec_attr = Arr::except($data, ['spec_options', 'devicetypes']);
            $spec_option = Arr::only($data, ['spec_options']);
            $spec_type = Arr::only($data, ['devicetypes']);
           // dd($spec_attr, $spec_option, $spec_type);


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

            $row_attr->deviceTypes()->sync( $data['devicetypes']  ?? [] );
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

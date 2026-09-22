<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreSpecAttributeRequest;
use App\Http\Requests\Device\UpdateSpecAttributeRequest;
use App\Models\DeviceType;
use App\Models\SpecAttribute;
use App\Services\Devices\SpecAttributesService;

class SpecAttributeController extends Controller
{
    public function __construct(
        public SpecAttributesService $spec_attributes_service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spc_attributes =  $this->spec_attributes_service->getList()->paginate(5);

        return view("device.spec-attributes.index", [
            'spc_attributes' => $spc_attributes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('device.spec-attributes.create', [
            'devicetypes' => DeviceType::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecAttributeRequest $request)
    {
        $data = $request->validated();
        $data['is_filterable']   = $request->boolean('is_filterable');
        $data['is_required']     = $request->boolean('is_required');

        $this->spec_attributes_service->insert($data);

        return $this->spec_attributes_service->to(
            'spec-attribute.index',
            'success',
            'Attribute has been created successfully.'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpecAttribute $spec_attribute)
    {
        $spec_attribute->load('specOptions', 'deviceTypes');

        return view("device.spec-attributes.edit", [
            'spec_attribute' =>  $spec_attribute,
            'devicetypes' => DeviceType::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecAttributeRequest $request, SpecAttribute $spec_attribute)
    {
        $data = $request->validated();
        $data['is_filterable'] = $request->boolean('is_filterable');
        $data['is_required']     = $request->boolean('is_required');

        $this->spec_attributes_service->update($data, $spec_attribute);

        return $this->spec_attributes_service->to(
            'spec-attribute.index',
            'success',
            'Attribute has been updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpecAttribute $spec_attribute)
    {
        $this->spec_attributes_service->delete($spec_attribute);

        return $this->spec_attributes_service->to(
            'spec-attribute.index',
            'success',
            'Attribute deleted successfully.'
        );
    }
}

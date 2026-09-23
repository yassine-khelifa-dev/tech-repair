<?php

namespace App\Http\Controllers\Web\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceModelConfigurationRequest;
use App\Models\DeviceModel;
class DeviceModelConfigurationController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceModel $devicemodel)
    {

        $devicemodel->load([
            'brand',
            'type.specAttributes.specOptions' => fn ($query) => $query->where('is_active', true),
            'allowed_options',
        ]);

        return view('device.model-configurations.edit', compact('devicemodel'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDeviceModelConfigurationRequest $request, DeviceModel $devicemodel)
    {
        $options_selected =  $request->validated();

        $devicemodel->allowed_options()->sync( $options_selected['allowed_options'] );

        return redirect()->route('device-model-configuration.edit', $devicemodel->id)->with('success', 'Model configuration has been updated.');

    }
}

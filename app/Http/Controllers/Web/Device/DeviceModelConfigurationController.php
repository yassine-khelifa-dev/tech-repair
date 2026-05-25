<?php

namespace App\Http\Controllers\Web\Device;

use App\Models\DeviceModelConfiguration;
use Illuminate\Http\Request;
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

        $devicemodel->load(['brand', 'type.specAttributes.specOptions']);

        return view('device.model-configurations.edit', compact('devicemodel'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDeviceModelConfigurationRequest $request, DeviceModel $devicemodel)
    {
        $options_selected =  $request->validated();


        $data = collect($options_selected)
            ->filter(fn($v) => filled($v))
            ->map(function ($value) use ($devicemodel) {
                 return [
                    'spec_attribute_option_id' => $value,
                 ];
            })
            ->values()
            ->toArray();

        dd( $data);


        return redirect()->route('device-model-configuration.edit', $devicemodel->id)->with('success', 'Config has bene Updated');

    }
}

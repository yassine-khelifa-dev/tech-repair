<?php

namespace App\Services\Devices;

use App\Models\SpecAttribute;
use Illuminate\Support\Facades\DB;

class SpecAttributesService
{
    public function to(string $route, string $key, string $message)
    {

        return redirect()
            ->route($route)
            ->with($key, $message);
    }

    public function getList()
    {
        return  SpecAttribute::with(['specOptions', 'deviceTypes'])
            ->orderBy('sort_order')
            ->get();
    }


    public function insert(array $data)
    {
        DB::transaction(function ()  use ($data) {

            $attributeData = collect($data)
                ->except(['spec_options', 'devicetypes'])
                ->toArray();

            /** @var SpecAttribute::class */
            $row_attr =  SpecAttribute::create($attributeData);

            $spec_options =  collect($data['spec_options'] ?? [])
                ->filter(fn($v) => filled($v))
                ->map(
                    fn($v, $i)  =>
                    [
                        'value' => str($v)->slug('_'),
                        'label' => $v,
                        'sort_order' => $i,
                        'is_active' => true,
                    ]
                )->values()
                ->toArray();

            if (! empty($spec_options))
                $row_attr->specOptions()->createMany($spec_options);

            $row_attr->deviceTypes()->sync($data['devicetypes']  ?? []);
        });
    }


    public function update(array $data, SpecAttribute $spec_attribute)
    {
        DB::transaction(function ()  use ($data, $spec_attribute) {

            $attributeData = collect($data)
                ->except(['spec_options', 'devicetypes'])
                ->toArray();
            /** @var SpecAttribute::class */
            $spec_attribute->update($attributeData);

            $spec_options =  collect($data['spec_options'] ?? [])
                ->filter(fn($v) => filled($v))
                ->map(
                    fn($v, $i)  =>
                    [
                        'value' => str($v)->slug('_'),
                        'label' => $v,
                        'sort_order' => $i,
                        'is_active' => true,
                    ]
                )->values()
                ->toArray();

            $spec_attribute->specOptions()->delete();

            if (! empty($spec_options)) {
                $spec_attribute->specOptions()->createMany($spec_options);
            }

            $spec_attribute->deviceTypes()->sync($data['devicetypes']  ?? []);
        });
    }


    public function delete(SpecAttribute $spec_attribute)
    {
        $spec_attribute->delete();
    }
}

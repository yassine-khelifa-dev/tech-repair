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
            ->latest()
            ;
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
                ->filter(fn($v) => filled($v['value']))
                ->map(
                    fn($option, $i)  =>
                    [
                        //'id' ignore for creation id=null
                        'value' => str($option['value'])->slug('_'),
                        'label' => $option['value'],
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
                ->filter(fn($v) => filled($v['value']))
                ->map(
                    fn($option, $i)  =>
                    [
                        'id'   => $option['id'] ?? null,
                        'value' => str($option['value'])->slug('_'),
                        'label' => $option['value'],
                        'sort_order' => $i,
                        'is_active' => true,
                    ]
                );

            // delete  options :
            $options_ids_old = $spec_attribute->specOptions()->pluck('id')->toArray();
            $options_ids_new = $spec_options->pluck('id')->toArray();

            $options_ids_deleted = array_diff($options_ids_old, $options_ids_new);

            $spec_attribute->specOptions()
                ->whereIn('id', $options_ids_deleted)
                ->delete();
                //Todo: ->update(['is_active' => false])

            //update  options :
            foreach ($spec_options as $option) {
                if ($option['id'] !== null) {
                    $id =  $option['id'];
                    unset($option['id']);
                    $spec_attribute->specOptions()->where('id', $id)->update($option);
                }
            };

             // insert new options :
            $options_new_value = $spec_options->filter(function ($option) {
                return $option['id'] === null;
            })->values()->toArray();

            if (! empty($options_new_value)) {
                $spec_attribute->specOptions()->createMany($options_new_value);
            }

            $spec_attribute->deviceTypes()->sync($data['devicetypes']  ?? []);
        });
    }



    public function delete(SpecAttribute $spec_attribute)
    {
        $spec_attribute->delete();
    }
}

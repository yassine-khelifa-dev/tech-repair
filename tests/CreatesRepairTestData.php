<?php

namespace Tests;

use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Models\SpecAttribute;
use App\Models\SpecAttributeOption;
use App\Models\User;

trait CreatesRepairTestData
{

    private function createUser(): User
    {
        return User::create([
            "name" => "KHELIFA YASSINE",
            "email" => "admin@gmail.com",
            "password" => "Test@test",
            "confirm_password" => "Test@test"
        ]);
    }


    private function createDeviceModel(): DeviceModel
    {
        $brand = Brand::create([
            'name' => 'Apple',
            'slug' => 'apple',
        ]);

        $type = DeviceType::create([
            'name' => 'Smartphone',
            'slug' => 'smartphone',
        ]);

        return DeviceModel::create([
            'name' => 'iPhone 17 Pro Max',
            'slug' => 'iphone-17-pro-max',
            'brand_id' => $brand->id,
            'device_type_id' => $type->id,
        ]);
    }

    private function createOptions(): array
    {
        $attributeColor = SpecAttribute::create([
            'name' => 'Color',
            'code' => 'color',
            'input_type' => 'select',
            'unit' => 'none',
        ]);

        $attributeRam = SpecAttribute::create([
            'name' => 'Ram',
            'code' => 'ram',
            'input_type' => 'select',
            'unit' => 'GB',
        ]);

        $optionBlack = SpecAttributeOption::create([
            'spec_attribute_id' => $attributeColor->id,
            'value' => 'black',
            'label' => 'Black',
        ]);

        $optionEight = SpecAttributeOption::create([
            'spec_attribute_id' => $attributeRam->id,
            'value' => '8',
            'label' => '8',
        ]);

        return [
            'black' => $optionBlack,
            'eight' => $optionEight,
        ];
    }

    private function validTicketData(DeviceModel $deviceModel, array $options): array
    {
        return [
            'fullname' => 'yassine',
            'email' => 'yassine@fr.lo',
            'phone' => '3848484',
            'selected_option_ids' => [
                $options['black']->id,
                $options['eight']->id,
            ],
            'images_device' => [],
            'technician_note' => 'Veniam ea non d incididunt dolore qui tempor.',
            'final_price' => '99',
            'estimated_price' => '90',
            'issue_description' => 'Magna in ut do tempor sunt officia.',
            'sn' => 'JH76TGBUY',
            'imei' => 'JS8D78D7D',
            'device_model_id' => $deviceModel->id,
        ];
    }
}

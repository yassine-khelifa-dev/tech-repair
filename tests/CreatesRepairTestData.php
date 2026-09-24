<?php

namespace Tests;

use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Models\SpecAttribute;
use App\Models\SpecAttributeOption;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait CreatesRepairTestData
{
    use WithFaker;

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


    private function createAttributeWithOptions(int $n = 5)
    {
        $d_attr = SpecAttribute::factory()->create();
        SpecAttributeOption::factory($n)->create([
            'spec_attribute_id' => $d_attr->id
        ]);

        $deviceTypeIds = DeviceType::pluck('id')->all();

        $d_attr->deviceTypes()->sync($deviceTypeIds);

        $d_attr->load('specOptions', 'deviceTypes');

        return $d_attr;
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

        $deviceTypeIds = DeviceType::pluck('id')->all();

        // link:  DeviceType <-> SpecAttribute
        $attributeRam->deviceTypes()->sync($deviceTypeIds);
        $attributeColor->deviceTypes()->sync($deviceTypeIds);


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
            'fullname' => 'User Test',
            'email' => "test@test.com",
            'phone' => $this->faker()->numberBetween(100000000, 1000000000),
            'selected_option_ids' => [
                $options['black']->id,
                $options['eight']->id,
            ],
            'images_device' => [],
            'technician_note' => $this->faker()->sentence(4),
            'final_price' => $this->faker()->numberBetween(10, 200),
            'estimated_price' => $this->faker()->numberBetween(100, 150),
            'issue_description' => $this->faker()->paragraph(),
            'sn' => $this->faker()->imei(),
            'imei' => $this->faker()->imei(),
            'device_model_id' => $deviceModel->id,
        ];
    }


    //=========================================================
    //====================       API       ====================
    //=========================================================

    private function validTicketDataForApi(DeviceModel $deviceModel, array $options): array
    {
        return [
            'fullname' => 'User Test',
            'email' => $this->faker()->email(),
            'phone' => $this->faker()->numberBetween(100000000, 1000000000),
            'option_ids' => [
                $options['black']->id,
                $options['eight']->id,
            ],
            'images_device' => [],
            'technician_note' => $this->faker()->sentence(4),
            'final_price' => $this->faker()->numberBetween(10, 200),
            'estimated_price' => $this->faker()->numberBetween(100, 150),
            'issue_description' => $this->faker()->paragraph(),
            'sn' => $this->faker()->imei(),
            'imei' => $this->faker()->imei(),
            'device_model_id' => $deviceModel->id,
        ];
    }


    private function badTicketDataForApi_without_email_options(DeviceModel $deviceModel, array $options): array
    {
        return [
            'fullname' => 'User Test',
            'phone' => $this->faker()->numberBetween(100000000, 1000000000),
            'images_device' => [],
            'technician_note' => $this->faker()->sentence(4),
            'final_price' => $this->faker()->numberBetween(10, 200),
            'estimated_price' => $this->faker()->numberBetween(100, 150),
            'issue_description' => $this->faker()->paragraph(),
            'sn' => $this->faker()->imei(),
            'imei' => $this->faker()->imei(),
            'device_model_id' => $deviceModel->id,
        ];
    }

    private function validTicketDataForApi_with_file(DeviceModel $deviceModel, array $options): array
    {
        return [
            'images_device' => [UploadedFile::fake()->image('device-photo.jpg')],
            'fullname' => 'User Test',
            'email' => $this->faker()->email(),
            'phone' => $this->faker()->numberBetween(pow(10, 9), pow(10, 10)),
            'option_ids' => [
                $options['black']->id,
                $options['eight']->id,
            ],
            'technician_note' => $this->faker()->sentence(4),
            'final_price' => $this->faker()->numberBetween(10, 200),
            'estimated_price' => $this->faker()->numberBetween(100, 150),
            'issue_description' => $this->faker()->paragraph(),
            'sn' => $this->faker()->imei(),
            'imei' => $this->faker()->imei(),
            'device_model_id' => $deviceModel->id,

        ];
    }

    private function validTicketDataForApi_with_wrong_options(DeviceModel $deviceModel)
    {
        // create attr-options :
        $attributeColor = SpecAttribute::create([
            'name' => 'Color',
            'code' => 'color',
            'input_type' => 'select',
            'unit' => 'none',
        ]);
        $optionBlack = SpecAttributeOption::create([
            'spec_attribute_id' => $attributeColor->id,
            'value' => 'black',
            'label' => 'Black',
        ]);

        $optionRed = SpecAttributeOption::create([
            'spec_attribute_id' => $attributeColor->id,
            'value' => 'red',
            'label' => 'Red',
        ]);

        return [
            'fullname' => 'User Test',
            'email' => $this->faker()->email(),
            'phone' => $this->faker()->numberBetween(100000000, 1000000000),
            'option_ids' => [
                $optionRed->id,
                $optionBlack->id
            ],
            'images_device' => [],
            'technician_note' => $this->faker()->sentence(4),
            'final_price' => $this->faker()->numberBetween(10, 200),
            'estimated_price' => $this->faker()->numberBetween(100, 150),
            'issue_description' => $this->faker()->paragraph(),
            'sn' => $this->faker()->imei(),
            'imei' => $this->faker()->imei(),
            'device_model_id' => $deviceModel->id,
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Models\SpecAttribute;
use App\Models\SpecAttributeOption;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => env('DEMO_ADMIN_EMAIL', 'tech-repair-admin@eprostam.com')],
            [
                'name' => env('DEMO_ADMIN_NAME', 'Tech Repair Admin'),
                'password' => Hash::make(env('DEMO_ADMIN_PASSWORD', 'TechRepair2026!')),
            ]
        );

        $admin->forceFill([
            'role' => 'admin',
            'email_verified_at' => now(),
        ])->save();

        $brands = collect([
            'Apple',
            'Samsung',
            'Google',
            'Xiaomi',
            'Huawei',
            'Sony',
            'LG',
            'Lenovo',
            'HP',
            'Dell',
            'Asus',
            'Acer',
            'Microsoft',
            'Nintendo',
            'OnePlus',
            'Oppo',
            'Vivo',
            'Motorola',
            'Nokia',
            'Realme',
        ])->mapWithKeys(fn (string $name) => [
            $name => Brand::updateOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            ),
        ]);

        $deviceTypes = collect([
            'Smartphone',
            'Tablet',
            'Laptop',
            'Desktop',
            'Smartwatch',
            'Headphones',
            'Earbuds',
            'Game Console',
            'Television',
            'Monitor',
            'Printer',
            'Router',
            'Speaker',
            'Camera',
        ])->mapWithKeys(fn (string $name) => [
            $name => DeviceType::updateOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            ),
        ]);

        $attributes = $this->seedAttributes();
        $this->attachAttributesToDeviceTypes($attributes, $deviceTypes);
        $this->seedDeviceModels($brands, $deviceTypes, $attributes);
    }

    /**
     * @return array<string, SpecAttribute>
     */
    private function seedAttributes(): array
    {
        $definitions = [
            'Color' => [
                'code' => 'color',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => true,
                'is_required' => true,
                'options' => [
                    'Black',
                    'White',
                    'Silver',
                    'Gold',
                    'Space Gray',
                    'Graphite',
                    'Midnight',
                    'Starlight',
                    'Blue',
                    'Sierra Blue',
                    'Pacific Blue',
                    'Sky Blue',
                    'Navy',
                    'Green',
                    'Alpine Green',
                    'Purple',
                    'Deep Purple',
                    'Pink',
                    'Red',
                    'Yellow',
                    'Orange',
                    'Natural Titanium',
                    'Blue Titanium',
                    'White Titanium',
                    'Black Titanium',
                    'Desert Titanium',
                    'Titanium Gray',
                ],
            ],
            'RAM' => [
                'code' => 'ram',
                'input_type' => 'select',
                'unit' => 'GB',
                'is_filterable' => true,
                'is_required' => true,
                'options' => ['1 GB', '2 GB', '3 GB', '4 GB', '6 GB', '8 GB', '12 GB', '16 GB', '18 GB', '24 GB', '32 GB', '64 GB'],
            ],
            'Storage' => [
                'code' => 'storage',
                'input_type' => 'select',
                'unit' => 'GB/TB',
                'is_filterable' => true,
                'is_required' => true,
                'options' => ['16 GB', '32 GB', '64 GB', '128 GB', '256 GB', '512 GB', '1 TB', '2 TB', '4 TB', '8 TB'],
            ],
            'Processor' => [
                'code' => 'processor',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => true,
                'is_required' => false,
                'options' => [
                    'Apple A14 Bionic',
                    'Apple A15 Bionic',
                    'Apple A16 Bionic',
                    'Apple A17 Pro',
                    'Apple A18',
                    'Apple M1',
                    'Apple M2',
                    'Apple M3',
                    'Apple M4',
                    'Snapdragon 8 Gen 2',
                    'Snapdragon 8 Gen 3',
                    'Snapdragon 8 Elite',
                    'Snapdragon 7 Gen 3',
                    'Google Tensor G3',
                    'Google Tensor G4',
                    'Exynos 2400',
                    'MediaTek Dimensity 9300',
                    'Intel Core i5',
                    'Intel Core i7',
                    'Intel Core i9',
                    'AMD Ryzen 5',
                    'AMD Ryzen 7',
                    'AMD Ryzen 9',
                ],
            ],
            'Screen Size' => [
                'code' => 'screen_size',
                'input_type' => 'select',
                'unit' => 'in',
                'is_filterable' => true,
                'is_required' => false,
                'options' => ['4.7"', '5.4"', '6.1"', '6.3"', '6.5"', '6.7"', '6.8"', '6.9"', '8.3"', '10.9"', '11"', '12.9"', '13"', '14"', '15.6"', '16"', '17.3"', '24"', '27"', '32"', '55"', '65"'],
            ],
            'Display Type' => [
                'code' => 'display_type',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => true,
                'is_required' => false,
                'options' => ['LCD', 'IPS LCD', 'OLED', 'AMOLED', 'Super AMOLED', 'Dynamic AMOLED 2X', 'Retina', 'Super Retina XDR', 'Mini-LED', 'Micro-LED', 'E-Ink'],
            ],
            'Battery Capacity' => [
                'code' => 'battery_capacity',
                'input_type' => 'select',
                'unit' => 'mAh',
                'is_filterable' => false,
                'is_required' => false,
                'options' => ['2000 mAh', '3000 mAh', '4000 mAh', '5000 mAh', '6000 mAh', '8000 mAh', '10000 mAh'],
            ],
            'Connectivity' => [
                'code' => 'connectivity',
                'input_type' => 'multiselect',
                'unit' => '',
                'is_filterable' => true,
                'is_required' => false,
                'options' => ['Wi-Fi', 'Wi-Fi 6', 'Wi-Fi 6E', 'Wi-Fi 7', 'Bluetooth', '4G LTE', '5G', 'NFC', 'GPS', 'Ethernet'],
            ],
            'Operating System' => [
                'code' => 'operating_system',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => true,
                'is_required' => false,
                'options' => ['iOS', 'iPadOS', 'Android', 'Windows', 'macOS', 'ChromeOS', 'Linux', 'Wear OS', 'watchOS', 'Tizen', 'webOS'],
            ],
            'Charging Port' => [
                'code' => 'charging_port',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => true,
                'is_required' => false,
                'options' => ['Lightning', 'USB-C', 'Micro-USB', 'MagSafe', 'DC Jack', 'Wireless Charging'],
            ],
            'SIM Type' => [
                'code' => 'sim_type',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => false,
                'is_required' => false,
                'options' => ['Single SIM', 'Dual SIM', 'eSIM', 'Nano SIM'],
            ],
            'Camera Setup' => [
                'code' => 'camera_setup',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => false,
                'is_required' => false,
                'options' => ['No Camera', 'Single Camera', 'Dual Camera', 'Triple Camera', 'Quad Camera'],
            ],
            'Device Condition' => [
                'code' => 'device_condition',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => true,
                'is_required' => false,
                'options' => ['New', 'Like New', 'Good', 'Fair', 'Damaged', 'Water Damaged'],
            ],
            'Warranty' => [
                'code' => 'warranty',
                'input_type' => 'select',
                'unit' => '',
                'is_filterable' => false,
                'is_required' => false,
                'options' => ['No Warranty', '3 Months', '6 Months', '12 Months', '24 Months'],
            ],
        ];

        $attributes = [];

        foreach ($definitions as $name => $definition) {
            $attribute = SpecAttribute::updateOrCreate(
                ['code' => $definition['code']],
                [
                    'name' => $name,
                    'input_type' => $definition['input_type'],
                    'unit' => $definition['unit'],
                    'is_filterable' => $definition['is_filterable'],
                    'is_required' => $definition['is_required'],
                    'sort_order' => count($attributes) + 1,
                ]
            );

            foreach ($definition['options'] as $index => $option) {
                SpecAttributeOption::updateOrCreate(
                    [
                        'spec_attribute_id' => $attribute->id,
                        'value' => Str::slug($option),
                    ],
                    [
                        'label' => $option,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ]
                );
            }

            $attributes[$name] = $attribute->fresh('specOptions');
        }

        return $attributes;
    }

    /**
     * @param array<string, SpecAttribute> $attributes
     */
    private function attachAttributesToDeviceTypes(array $attributes, mixed $deviceTypes): void
    {
        $map = [
            'Smartphone' => ['Color', 'RAM', 'Storage', 'Processor', 'Screen Size', 'Display Type', 'Battery Capacity', 'Connectivity', 'Operating System', 'Charging Port', 'SIM Type', 'Camera Setup', 'Device Condition', 'Warranty'],
            'Tablet' => ['Color', 'RAM', 'Storage', 'Processor', 'Screen Size', 'Display Type', 'Battery Capacity', 'Connectivity', 'Operating System', 'Charging Port', 'SIM Type', 'Camera Setup', 'Device Condition', 'Warranty'],
            'Laptop' => ['Color', 'RAM', 'Storage', 'Processor', 'Screen Size', 'Display Type', 'Connectivity', 'Operating System', 'Charging Port', 'Device Condition', 'Warranty'],
            'Desktop' => ['Color', 'RAM', 'Storage', 'Processor', 'Connectivity', 'Operating System', 'Device Condition', 'Warranty'],
            'Smartwatch' => ['Color', 'Storage', 'Processor', 'Screen Size', 'Display Type', 'Battery Capacity', 'Connectivity', 'Operating System', 'Charging Port', 'Device Condition', 'Warranty'],
            'Headphones' => ['Color', 'Battery Capacity', 'Connectivity', 'Charging Port', 'Device Condition', 'Warranty'],
            'Earbuds' => ['Color', 'Battery Capacity', 'Connectivity', 'Charging Port', 'Device Condition', 'Warranty'],
            'Game Console' => ['Color', 'Storage', 'Processor', 'Connectivity', 'Operating System', 'Device Condition', 'Warranty'],
            'Television' => ['Color', 'Screen Size', 'Display Type', 'Connectivity', 'Operating System', 'Device Condition', 'Warranty'],
            'Monitor' => ['Color', 'Screen Size', 'Display Type', 'Connectivity', 'Device Condition', 'Warranty'],
            'Printer' => ['Color', 'Connectivity', 'Device Condition', 'Warranty'],
            'Router' => ['Color', 'Connectivity', 'Device Condition', 'Warranty'],
            'Speaker' => ['Color', 'Battery Capacity', 'Connectivity', 'Charging Port', 'Device Condition', 'Warranty'],
            'Camera' => ['Color', 'Storage', 'Screen Size', 'Display Type', 'Battery Capacity', 'Connectivity', 'Charging Port', 'Device Condition', 'Warranty'],
        ];

        foreach ($map as $typeName => $attributeNames) {
            $type = $deviceTypes[$typeName] ?? null;

            if (! $type) {
                continue;
            }

            $sync = [];

            foreach ($attributeNames as $index => $attributeName) {
                $attribute = $attributes[$attributeName] ?? null;

                if ($attribute) {
                    $sync[$attribute->id] = [
                        'is_required' => in_array($attributeName, ['Color', 'RAM', 'Storage'], true),
                        'sort_order' => $index + 1,
                    ];
                }
            }

            $type->specAttributes()->syncWithoutDetaching($sync);
        }
    }

    /**
     * @param array<string, SpecAttribute> $attributes
     */
    private function seedDeviceModels(mixed $brands, mixed $deviceTypes, array $attributes): void
    {
        $models = [
            [
                'name' => 'iPhone 17 Pro Max',
                'brand' => 'Apple',
                'type' => 'Smartphone',
                'options' => [
                    'Color' => ['Blue Titanium', 'White Titanium', 'Black Titanium', 'Desert Titanium'],
                    'RAM' => ['8 GB'],
                    'Storage' => ['256 GB', '512 GB', '1 TB', '2 TB'],
                    'Processor' => ['Apple A18'],
                    'Screen Size' => ['6.9"'],
                    'Display Type' => ['Super Retina XDR'],
                    'Connectivity' => ['Wi-Fi 7', '5G', 'NFC', 'GPS'],
                    'Operating System' => ['iOS'],
                    'Charging Port' => ['USB-C', 'Wireless Charging'],
                    'SIM Type' => ['eSIM', 'Nano SIM'],
                    'Camera Setup' => ['Triple Camera'],
                ],
            ],
            [
                'name' => 'Galaxy S24 Ultra',
                'brand' => 'Samsung',
                'type' => 'Smartphone',
                'options' => [
                    'Color' => ['Black Titanium', 'Titanium Gray', 'Blue', 'Yellow'],
                    'RAM' => ['12 GB'],
                    'Storage' => ['256 GB', '512 GB', '1 TB'],
                    'Processor' => ['Snapdragon 8 Gen 3'],
                    'Screen Size' => ['6.8"'],
                    'Display Type' => ['Dynamic AMOLED 2X'],
                    'Connectivity' => ['Wi-Fi 7', '5G', 'NFC', 'GPS'],
                    'Operating System' => ['Android'],
                    'Charging Port' => ['USB-C', 'Wireless Charging'],
                    'SIM Type' => ['Dual SIM', 'eSIM'],
                    'Camera Setup' => ['Quad Camera'],
                ],
            ],
            [
                'name' => 'Pixel 9 Pro',
                'brand' => 'Google',
                'type' => 'Smartphone',
                'options' => [
                    'Color' => ['Black', 'White', 'Pink', 'Green'],
                    'RAM' => ['16 GB'],
                    'Storage' => ['128 GB', '256 GB', '512 GB', '1 TB'],
                    'Processor' => ['Google Tensor G4'],
                    'Screen Size' => ['6.3"'],
                    'Display Type' => ['OLED'],
                    'Connectivity' => ['Wi-Fi 7', '5G', 'NFC', 'GPS'],
                    'Operating System' => ['Android'],
                    'Charging Port' => ['USB-C', 'Wireless Charging'],
                    'SIM Type' => ['eSIM', 'Nano SIM'],
                    'Camera Setup' => ['Triple Camera'],
                ],
            ],
            [
                'name' => 'iPad Pro 13',
                'brand' => 'Apple',
                'type' => 'Tablet',
                'options' => [
                    'Color' => ['Silver', 'Space Gray'],
                    'RAM' => ['8 GB', '16 GB'],
                    'Storage' => ['256 GB', '512 GB', '1 TB', '2 TB'],
                    'Processor' => ['Apple M4'],
                    'Screen Size' => ['13"'],
                    'Display Type' => ['OLED'],
                    'Connectivity' => ['Wi-Fi 7', '5G'],
                    'Operating System' => ['iPadOS'],
                    'Charging Port' => ['USB-C'],
                    'Camera Setup' => ['Single Camera'],
                ],
            ],
            [
                'name' => 'MacBook Pro 14',
                'brand' => 'Apple',
                'type' => 'Laptop',
                'options' => [
                    'Color' => ['Silver', 'Space Gray'],
                    'RAM' => ['16 GB', '24 GB', '32 GB', '64 GB'],
                    'Storage' => ['512 GB', '1 TB', '2 TB', '4 TB'],
                    'Processor' => ['Apple M3', 'Apple M4'],
                    'Screen Size' => ['14"'],
                    'Display Type' => ['Mini-LED'],
                    'Connectivity' => ['Wi-Fi 6E', 'Bluetooth'],
                    'Operating System' => ['macOS'],
                    'Charging Port' => ['MagSafe', 'USB-C'],
                ],
            ],
            [
                'name' => 'Dell XPS 15',
                'brand' => 'Dell',
                'type' => 'Laptop',
                'options' => [
                    'Color' => ['Silver', 'Black'],
                    'RAM' => ['16 GB', '32 GB', '64 GB'],
                    'Storage' => ['512 GB', '1 TB', '2 TB'],
                    'Processor' => ['Intel Core i7', 'Intel Core i9'],
                    'Screen Size' => ['15.6"'],
                    'Display Type' => ['OLED', 'IPS LCD'],
                    'Connectivity' => ['Wi-Fi 6E', 'Bluetooth'],
                    'Operating System' => ['Windows', 'Linux'],
                    'Charging Port' => ['USB-C'],
                ],
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'brand' => 'Sony',
                'type' => 'Headphones',
                'options' => [
                    'Color' => ['Black', 'Silver', 'Blue'],
                    'Battery Capacity' => ['10000 mAh'],
                    'Connectivity' => ['Bluetooth'],
                    'Charging Port' => ['USB-C'],
                ],
            ],
            [
                'name' => 'PlayStation 5',
                'brand' => 'Sony',
                'type' => 'Game Console',
                'options' => [
                    'Color' => ['White', 'Black'],
                    'Storage' => ['1 TB'],
                    'Connectivity' => ['Wi-Fi 6', 'Bluetooth', 'Ethernet'],
                    'Operating System' => ['Linux'],
                ],
            ],
            [
                'name' => 'LG OLED C4 55',
                'brand' => 'LG',
                'type' => 'Television',
                'options' => [
                    'Color' => ['Black'],
                    'Screen Size' => ['55"'],
                    'Display Type' => ['OLED'],
                    'Connectivity' => ['Wi-Fi 6', 'Bluetooth', 'Ethernet'],
                    'Operating System' => ['webOS'],
                ],
            ],
        ];

        foreach ($models as $modelData) {
            $model = DeviceModel::updateOrCreate(
                [
                    'name' => $modelData['name'],
                    'brand_id' => $brands[$modelData['brand']]->id,
                ],
                [
                    'slug' => Str::slug($modelData['name']),
                    'device_type_id' => $deviceTypes[$modelData['type']]->id,
                    'is_active' => true,
                ]
            );

            $optionIds = [];

            foreach ($modelData['options'] as $attributeName => $labels) {
                $attribute = $attributes[$attributeName] ?? null;

                if (! $attribute) {
                    continue;
                }

                $optionIds = [
                    ...$optionIds,
                    ...$attribute->specOptions()
                        ->whereIn('label', $labels)
                        ->pluck('id')
                        ->all(),
                ];
            }

            $model->allowed_options()->sync($optionIds);
        }


    }
}

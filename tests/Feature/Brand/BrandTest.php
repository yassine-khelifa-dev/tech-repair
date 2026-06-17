<?php

namespace Tests\Feature\Brand;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_can_create_a_brand(): void
    {

        $brand = Brand::create([
            'name' => 'Seven Tech',
            'slug' => 'seven-tech'
        ]);

        $this->assertInstanceOf(Brand::class, $brand);

        $this->assertDatabaseHas('brands', [
            'name' => 'Seven Tech',
            'slug' => 'seven-tech'
        ]);
    }

    public function test_can_update_a_brand(): void
    {

        $brand = Brand::create([
            'name' => 'Seven Tech',
            'slug' => 'seven-tech'
        ]);

        $brand->update([
            'name' => 'Seven',
            'slug' => 'seven'

        ]);

        $this->assertInstanceOf(Brand::class, $brand);

        $this->assertDatabaseHas('brands', [
            'name' => 'Seven',
            'slug' => 'seven'
        ]);
    }


    public function test_can_delete_a_brand(): void
    {

        $brand = Brand::create([
            'name' => 'Seven Tech',
            'slug' => 'seven-tech'
        ]);

        $brand->delete();

        $this->assertDatabaseMissing('brands', [
            'name' => 'Seven Tech',
            'slug' => 'seven-tech'
        ]);
    }
}

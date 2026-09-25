<?php

namespace App\Http\Controllers\Web\Device;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Brand::class);
        $brands = Brand::latest()->paginate(10);
        return view('device.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Brand::class);
        return view('device.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        Gate::authorize('create', Brand::class);

        $brand = $request->validated();
        $brand['slug'] = Str::slug($brand['name']);

        Brand::create($brand);
        return redirect()->route('brand.index')->with('success', 'Brand has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        Gate::authorize('update', $brand);

        return view('device.brand.edit', ['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        Gate::authorize('update', $brand);

        $data = $request->validate([
            'name' => 'required|min:3|max:255|unique:brands,name,' . $brand->id,
        ]);

        $brand->update($data);

        if ($brand->wasChanged())
            return redirect()->route('brand.index')->with('success', 'Brand has been updated.');
        else
            return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        Gate::authorize('delete', $brand);

        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand has been deleted.');
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', [
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request)
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = $request->validated();
        $brand['slug'] = Str::slug($brand['name']);

        Brand::create( $brand );



        return redirect()->route('brand.index')->with('success', 'Brand has bene craeted');



    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit', ['brand' => $brand]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:255|unique:brands,name,' . $brand->id,
        ]);

        $brand->update( $data );

        if($brand->wasChanged())
            return redirect()->route('brand.index')->with('success', 'Brand has bene updated');
        else
            return redirect()->route('brand.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
       $brand->delete();

       return redirect()->route('brand.index')->with('success', 'Brand has bene deleted');
    }
}

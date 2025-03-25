<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Backend\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('backend.product.products.index', ['products' => Product::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('backend.product.products.create', ['isShown' => false, 'categories' => Product\Category::where(['status' => 1])->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required',
            'product_name'  => 'required',
        ]);
        try {
            DB::transaction(function () use ($request){
                Product::createOrUpdateProduct($request);
            });
            Toastr::success('Product created successfully.');
            return back();
        } catch (\Exception $exception)
        {
            return $exception->getMessage();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('backend.product.products.create', ['product' => $product, 'isShown' => true, 'categories' => Product\Category::where(['status' => 1])->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Request $request)
    {
        return view('backend.product.products.create', ['product' => $product, 'isShown' => false, 'categories' => Product\Category::where(['status' => 1])->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id'  => 'required',
            'product_name'  => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $id){
                Product::createOrUpdateProduct($request, $id);
            });
            Toastr::success('Product updated successfully.');
            return redirect(route('products.index'));
        } catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
//        GasStationEmployee::find($id)->delete();

        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }
}

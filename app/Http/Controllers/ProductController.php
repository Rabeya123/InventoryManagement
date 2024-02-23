<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Jobs\Product\CreateProduct;
use App\Jobs\Product\DeleteProduct;
use App\Jobs\Product\UpdateProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Toastr;
class ProductController 
{
    public function index()
    {   
        return view('product.index', [
            'Products' => Product::all()
        ]);
    }

    public function create()
    {
        return view('product.create',[
            'Categories' => Category::select('name','id')->get(),
            'Units' => Unit::select('name','id')->get()
        ]);
    }

    public function store(CreateProductRequest $request)
    {
        try {
            dispatch(new CreateProduct($request->validated()));
            Toastr::success('Product has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(Product $Product)
    {
        return view('product.edit',[
            'Product' => $Product,
            'Categories' => Category::select('name','id')->get(),
            'Units' => Unit::select('name','id')->get()
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            dispatch(new UpdateProduct($request->validated(),$product));
            Toastr::success('Product has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { dd($th);
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(Product $Product)
    {
        abort(403);
        try {
            dispatch(new DeleteProduct($Product));
            Toastr::success('Product has been deleted succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }
}

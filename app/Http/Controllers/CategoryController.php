<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Unit;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Jobs\Category\CreateCategory;
use App\Jobs\Category\UpdateCategory;
use App\Jobs\Category\DeleteCategory;
use Toastr;
class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index',[
            'Categories' => Category::all()
        ]);
    }

    public function create()
    {
        return view('category.create');
    }
    
    public function store(CreateCategoryRequest $request)
    {
        try {
            dispatch(new CreateCategory($request->validated()));
            Toastr::success('Category has been created succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function edit(Category $Category)
    {
        return view('category.edit',[
            'Category' => $Category
        ]);
    }
    
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            dispatch(new UpdateCategory($request->validated(), $id));
            Toastr::success('Category has been updated succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) { 
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

    public function destroy(Category $Category)
    { 
        try {
            dispatch(new DeleteCategory($Category));
            Toastr::success('Category has been deleted succesfully!', 'Success', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Someting wrong, please contact with admin!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }

}

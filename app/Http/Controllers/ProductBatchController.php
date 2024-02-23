<?php

namespace App\Http\Controllers;

use App\Models\ProductBatch;
use Illuminate\Http\Request;

class ProductBatchController extends Controller
{
    public function index()
    {
        return view('batch.index',[
            'ProductBatches' => ProductBatch::all()
        ]);
    }
}

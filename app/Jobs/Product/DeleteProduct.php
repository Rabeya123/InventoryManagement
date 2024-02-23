<?php

namespace App\Jobs\Product;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class DeleteProduct
{
    use Dispatchable;

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        $this->model->delete();
        return true;
    }
}

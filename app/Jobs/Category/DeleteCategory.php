<?php

namespace App\Jobs\Category;


use Illuminate\Foundation\Bus\Dispatchable;


class DeleteCategory
{
    use Dispatchable;


    public function __construct($model)
    {
        $this->model= $model;
    }


    public function handle()
    {
        $this->model->delete();
    }
}

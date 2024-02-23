<?php

namespace App\Jobs\Location;

use Illuminate\Foundation\Bus\Dispatchable;


class DeleteLocation 
{
    use Dispatchable;
    protected $model;

    public function __construct($model)
    {
        $this->model= $model;
    }

    public function handle()
    {
        $this->model->delete();
    }
}

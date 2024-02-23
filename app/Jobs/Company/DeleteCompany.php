<?php

namespace App\Jobs\Company;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class DeleteCompany
{
    use Dispatchable;

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        DB::beginTransaction();
            $this->model->contacts()->delete();
            $this->model->delete();
        DB::commit();
        return true;
    }
}

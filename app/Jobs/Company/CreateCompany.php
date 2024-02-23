<?php

namespace App\Jobs\Company;

use App\Jobs\Contact\CreateContact;
use App\Models\Company;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class CreateCompany
{
    use Dispatchable;
    
    protected $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        DB::beginTransaction();
            $Supplier = Company::create($this->request);
            dispatch(new CreateContact($Supplier, [
                'name' => request('contact_name'),
                'email' =>  request('contact_email'),
                'mobile' =>  request('contact_mobile')
            ])); 
        DB::commit();
    }
}

<?php

namespace App\Jobs\Company;

use App\Jobs\UpdateContact;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UpdateCompany
{
    use Dispatchable;

    protected $Model;
    protected $request;

    public function __construct($Model,$request)
    {
        $this->Model = $Model;
        $this->request = $request;
    }

    public function handle()
    {
        DB::beginTransaction();
            $this->Model->update($this->request);
            $Contact = Contact::where('contactable_type', Company::class)
                ->where('contactable_type', $this->Model->id)
                ->first();
            dispatch(new UpdateContact($Contact,[
                'contactable_id' => $this->request->contact_id,
                'name' => $this->request->contact_name,
                'email' => $this->request->contact_email,
                'mobile' => $this->request->contact_mobile
            ])); 
        DB::commit();
    }
}

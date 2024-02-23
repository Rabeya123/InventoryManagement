<?php

namespace App\Jobs\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UpdateContact
{
    use Dispatchable;

    protected $Model;
    protected $request;

    public function __construct($Model, $request)
    {
        $this->Model = $Model;
        $this->request = $request;
    }

    public function handle() : Contact
    { 
        $this->Model->update([
            'contactable_id' => $this->request['company_id'],
            'name' => $this->request['name'],
            'email' => $this->request['email'],
            'mobile' => $this->request['mobile'],
        ]);
        return $this->Model;
    }
}

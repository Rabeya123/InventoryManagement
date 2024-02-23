<?php

namespace App\Jobs\Contact;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateContact
{
    use Dispatchable;

    protected $Model;
    protected $request;

    public function __construct($Model, $request)
    {
        $this->Model = $Model;
        $this->request = $request;
    }

    public function handle()
    {
        $Contact = Contact::create([
            'contactable_type' => get_class($this->Model),
            'contactable_id' => $this->Model->id,
            'name' => $this->request['name'],
            'email' => $this->request['email'],
            'mobile' => $this->request['mobile']
        ]);

        $Contact->update([
            'code' => 'SC-' . $Contact->id
        ]);

        return $Contact;
    }
}

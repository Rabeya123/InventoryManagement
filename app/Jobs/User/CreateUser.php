<?php

namespace App\Jobs\User;

use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    use Dispatchable;

    protected $data; 

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function handle()
    {
        return User::create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'mobile' => $this->data['mobile'],
            'role_id' => $this->data['role_id'],
            'password' => Hash::make($this->data['password']),
        ]);
    }
}

<?php

namespace App\Jobs\User;
use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateUser
{
    use Dispatchable;
    protected $data;
    protected $id;


    public function __construct(array $data,$id)
    {
        $this->data= $data;
        $this->id=$id;
    }
    
    public function handle()
    {
        $User = User::findOrFail($this->id);
        $User->update($this->data);
        $User->refresh();
        return $User;
    }
}

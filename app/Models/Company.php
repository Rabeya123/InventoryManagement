<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }
    
    public function contact()
    {
        return $this->morphMany(Contact::class, 'contactable')
            ->orderBy('id','desc')
            ->take(1);
    }
}

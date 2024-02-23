<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function contactable()
    {
        return $this->morphTo();
    }

    // public function getNameAttribute($value)
    // {
    //     return $value . ' (' . $this->contactable->name . ')';
    // }

    public function getNameWithCompanyAttribute($value)
    {
        return $value . ' (' . $this->contactable->name . ')';
    }
}

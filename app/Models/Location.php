<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];
    
}

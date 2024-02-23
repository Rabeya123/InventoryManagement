<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomModel;

class Unit extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];
}

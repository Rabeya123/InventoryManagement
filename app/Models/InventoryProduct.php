<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryProduct extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];
    
    protected $table = 'inventory_histories';
}

<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function user()
    {
       return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function product()
    {
       return $this->belongsTo(Product::class, 'product_id', 'id')->withDefault();
    }
}

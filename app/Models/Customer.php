<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'ProviderID', 'ProviderID')->withDefault();
    }
}

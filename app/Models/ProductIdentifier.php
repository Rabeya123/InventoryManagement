<?php

namespace App\Models;

use App\Traits\CustomModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIdentifier extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function batch()
    {
        return $this->belongsTo(ProductBatch::class, 'batch_id', 'id')->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID', 'CustomerID')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withDefault();
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id')->withDefault();
    }

    public function getFloatUserAddAtAttribute($value)
    {
        return $this->float_user_id ? Carbon::parse($value)->format('d-m-Y, h:s:i') : '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'float_user_id', 'id')->withDefault([
            'name' => ''
        ]);
    }
}

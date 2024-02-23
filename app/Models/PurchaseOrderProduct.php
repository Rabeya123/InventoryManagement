<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProduct extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withDefault();
    }

    public function getAmountWithTaxAttribute($value)
    {
        return ($this->purchase_price/100) * (100+ $this->tax_percentile) * $this->quantity;
    }

    public function getAmountTaxAttribute($value)
    {
        return ($this->purchase_price/100) * ($this->tax_percentile) * $this->quantity;
    }

    public function getAmountAttribute($value)
    {
        return $this->purchase_price * $this->quantity;
    }
}

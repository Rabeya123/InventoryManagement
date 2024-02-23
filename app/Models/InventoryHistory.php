<?php

namespace App\Models;

use App\Traits\CustomModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    protected $appends = ['ref_type'];

    public function setTypeAttribute($value)
    {
        if($value == 1) {
            $this->attributes['type'] = 'IN';
        } else {
            $this->attributes['type']  = 'OUT';
        }
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function referenceable()
    {
        return $this->morphTo();
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withDefault();
    }

    public function getRefTypeAttribute($value)
    { //return $this->referenceable_type;
        if( $this->referenceable_type == 'App\Models\PurchaseOrder') {
            $type = 'Purcahse' ;
        }else if( $this->referenceable_type == 'App\Models\Requisition') {
            $type = 'Delivery' ;
        }else if( $this->referenceable_type == 'App\Models\Inventory') {
            $type = 'Transfar' ;
        } else {
            $type = 'Others' ;
        }

        return $type ;
    }
}

<?php

namespace App\Models;

use App\Traits\CustomModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function products()
    {
        return $this->hasMany(RequisitionProduct::class,'requisition_id', 'id');
    }

    public function requisition_for()
    {
        return $this->belongsTo(User::class,'requisition_for_user_id')->withDefault();
    }

    public function requisition_by()
    {
        return $this->belongsTo(User::class,'created_by')->withDefault();
    }

    public function location()
    {
        return $this->belongsTo(Location::class,'location_id')->withDefault();
    }

    public function indentifiers()
    {
        return $this->belongsToMany(ProductIdentifier::class, 'requestion_product_identifer','requestion_id', 'indentifier_id');
    }

    public function getDeliveryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    // public function approved_by()
    // {
    //     return $this->belongsTo(User::class,'approved_by')->withDefault();
    // }
}

<?php

namespace App\Models;

use App\Traits\CustomModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function getOrderTotalAttribute()
    { 
        $total = 0;
        foreach($this->orders as $order) {
            $total_amount = $order->purchase_price * $order->quantity;
            if($order->tax_percentile > 0) {
                $total += $total_amount / 100 * (100 + $order->tax_percentile);  
            }else{
                $total += $total_amount;
            }
        }
        return $total;
    }

    public function scopeIsApproved($query)
    {
        return $query->whereNotNull('approved_by');
    }

    public function getTotalAttribute()
    {
        return number_format(($this->order_total + $this->service_charge + $this->others_charge), 2);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id')->withDefault();
    }

    public function shipping_address()
    {
        return $this->hasOne(ShippingAddress::class, 'id', 'shipping_address_id')->withDefault();
    }

    public function approved_user()
    {
        return $this->belongsTo(User::class,'approved_by')->withDefault();
    }
    
    public function orders()
    {
        return $this->hasMany(PurchaseOrderProduct::class, 'purchase_order_id', 'id');
    }

    public function conditions()
    {
        return $this->hasMany(PurchaseOrderCondition::class, 'purchase_order_id', 'id');
    }

}

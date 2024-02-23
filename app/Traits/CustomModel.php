<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
trait CustomModel
{
    public function created_user()
    {
        return $this->belongsTo(User::class,'created_by')->withDefault();
    }
    
    public function setDateAttribute($value)
    {
        return $this->attributes['date'] = Carbon::parse($value)->toDateString();
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function scopeIsActive($query) 
    {
        return $query->where('is_active', 1);
    }

    public static function boot() {
        parent::boot();
        
        self::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        self::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }
}

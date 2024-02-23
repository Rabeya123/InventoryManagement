<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'role_id',
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->withDefault();
    }
    
    public function scopeRegularUser($query)
    {
        return $query->whereNotIn('role_id', [1,2]);
    }

    public function scopeAdminUser($query)
    {
        return $query->whereNotIn('role_id', [1,2]);
    }

    public function getIsAdminAttribute($key)
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2){
            return true;
        }else{
            return false;
        }
    }

    public function getIsSuperAdminAttribute($key)
    {
        if (auth()->user()->role_id == 1){
            return true;
        }else{
            return false;
        }
    }
}

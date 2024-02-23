<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory, CustomModel;

    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany(InventoryHistory::class, 'referenceable_id', 'id')
            ->where('referenceable_type', Inventory::class);
    }
}

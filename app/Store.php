<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }

    public function invitation()
    {
        return $this->hasMany(Invitation::calss, 'requested_by_store', 'id');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class, 'store_id', 'id');
    }
}

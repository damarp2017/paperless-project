<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Store::class, 'requested_by_store', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }
}

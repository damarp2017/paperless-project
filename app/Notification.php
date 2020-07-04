<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public static $INVITATION = 1;
    public static $ORDER = 2;

    public function store()
    {
        return $this->belongsTo(Store::class,'sender', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'receiver', 'id');
    }
}

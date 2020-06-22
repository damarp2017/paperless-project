<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function buyer_user()
    {
        return $this->belongsTo(User::class, 'buy_by_user', 'id')->withTrashed();
    }

    public function seller_store()
    {
        return $this->belongsTo(Store::class, 'sell_by_store', 'id')->withTrashed();
    }

    public function buyer_store()
    {
        return $this->belongsTo(Store::class, 'buy_by_store', 'id')->withTrashed();
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}

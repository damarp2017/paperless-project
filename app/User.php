<?php

namespace App;

use App\Notifications\ApiResetPasswordNotification;
use App\Notifications\ApiVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function stores()
    {
        return $this->hasMany(Store::class, 'owner_id', 'id');
    }

    public function ownStore(Store $store)
    {
        return auth()->user()->id === $store->owner->id;
    }

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new ApiVerifyEmail());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ApiResetPasswordNotification($token));
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

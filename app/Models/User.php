<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Storage;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $primaryKey = 'user_id';

    protected $dates = ['deleted_at'];

    public function roles()
    {
        return $this->hasOne('App\Models\Roles');
    }

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'mobile_number',
        'country',
        'role_id',
        'is_active',
        'activation_token',
        'email_verified_at',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarUrlAttribute()
    {
        return Storage::url('avatars/' . $this->user_id . '/' . $this->avatar);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'service_provider_id';
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
        'service_provider_id',
        'name',
        'address',
        'email',
        'password',
        'latitude',
        'longitude',
        'mobile_number',
        'land_phone_number',
        'owner_name',
        'owner_contact_number',
        'opening_time',
        'closing_time',
        'updated_by',
        'created_by'
    ];

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

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProviderCategory::class, 'service_provider_id', 'service_provider_id');
    }
}

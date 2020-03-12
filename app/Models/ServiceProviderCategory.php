<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderCategory extends Model
{
    protected $primaryKey = 'service_provider_category_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_provider_id', 'category_id', 'created_by', 'updated_by',
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id', 'service_provider_id');
    }

    public function category()
    {
        return $this->hasMany(Category::class, 'category_id', 'category_id');
    }
}

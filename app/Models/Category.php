<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use Searchable;

    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'created_by', 'updated_by',
    ];


    public function categoryItem()
    {
        return $this->belongsTo(CategoryItem::class, 'category_id', 'category_id');
    }

    public function serviceProviderCategory()
    {
        return $this->hasMany(ServiceProviderCategory::class, 'category_id', 'category_id');
    }
}

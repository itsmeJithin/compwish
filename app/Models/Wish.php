<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{

    protected $primaryKey = 'wish_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_item_id',
        'description',
        'user_id',
        'latitude',
        'longitude',
        'is_journey',
        'journey_date',
        'is_completed',
        'is_cancelled',
        'created_at'
    ];

    public function categoryItem()
    {
        return $this->hasMany(CategoryItem::class, 'category_item_id', 'category_item_id');
    }
}

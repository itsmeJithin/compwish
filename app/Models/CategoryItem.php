<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class CategoryItem extends Model
{
    use Searchable;

    public $asYouType = true;

    protected $searchRules = [];

    protected $primaryKey = 'category_item_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'created_by', 'updated_by', 'category_id'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $this->category;
        $array = $this->toArray();
        $array['category_name'] = $array['category']['name'];
        unset($array['category']);
        return $array;
    }


    public function category()
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }

    public function wish()
    {
        return $this->belongsTo(Wish::class, 'category_item_id', 'category_item_id');
    }

}

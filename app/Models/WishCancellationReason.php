<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishCancellationReason extends Model
{

    protected $primaryKey = 'wish_cancellation_reason_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason_id', 'wish_id', 'description', 'other_reason', 'user_id', 'created_by', 'created_by'
    ];
}

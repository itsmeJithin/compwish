<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancellationReason extends Model
{

    protected $primaryKey = 'cancellation_reason_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason', 'created_by', 'created_by'
    ];
}

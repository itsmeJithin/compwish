<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishSetting extends Model
{
    protected $primaryKey = 'wish_setting_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wish_id',
        'is_notification_enabled',
        'send_notification_from',
        'send_notification_to',
        'is_reminder_enabled',
        'remind_in_radius',
    ];
}

<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PushNotification extends Model
{
    public function users() : BelongsToMany 
    {
        return $this->belongsToMany(User::class, 'push_notification_user');
    }
}

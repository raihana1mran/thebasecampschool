<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastMessage extends Model
{
    protected $fillable = [
        'audience',
        'subject',
        'message',
    ];
}

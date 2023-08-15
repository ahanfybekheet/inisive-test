<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendPost extends Model
{
    use HasFactory;

    protected $table = 'send_posts';

    protected $fillable = [
        'subscriber_id',
        'post_id',
    ];
}

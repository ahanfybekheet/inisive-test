<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use Notifiable;

    protected $fillable = [
        'website_id',
        'email',
    ];
    public function notifiedPosts() {
        return $this->belongsToMany(Post::class, 'send_posts');
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

}

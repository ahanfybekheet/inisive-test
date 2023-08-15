<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
    ];
    public function subscriptions()
    {
        return $this->hasMany(subscriber::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}

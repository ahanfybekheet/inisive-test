<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'website_id',
        'title',
        'description',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function scopeRetrieveUnnotifiedPosts($query)
    {
        $unnotifiedCondition = function ($subQuery) {
            $subQuery->whereDoesntHave('notifiedPosts', function ($innerQuery) {
                $innerQuery->where('send_posts.post_id', '!=', 'posts.id');
            });
        };
        return $query->whereHas('website', function ($subQuery) use ($unnotifiedCondition) {
            $subQuery->whereHas('subscriptions', $unnotifiedCondition);
        })->with(['website' => function ($subQuery) use ($unnotifiedCondition) {
            $subQuery->with(['subscriptions' => $unnotifiedCondition]);
        }])->get();
    }


}

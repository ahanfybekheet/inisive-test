<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\SendPost;
use App\Models\Subscriber;
use App\Notifications\PostNotification;

class SendSubscriberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Subscriber::with('website')->chunk(200, function ($subscribers) {
            foreach ($subscribers as $subscriber) {
                $website = $subscriber->website;
                $allPosts = $website->posts;
    
                // Get notified post IDs for the current subscriber
                $notifiedPosts = SendPost::where('subscriber_id', $subscriber->id)
                    ->whereIn('post_id', $allPosts->pluck('id'))
                    ->pluck('post_id')
                    ->toArray();
    
                $postsToNotify = [];
    
                foreach ($allPosts as $post) {
                    if (!in_array($post->id, $notifiedPosts)) {
                        $postsToNotify[] = $post;
                    }
                }
    
                if (!empty($postsToNotify)) {
                    SendPost::insert(array_map(function ($post) use ($subscriber) {
                        return [
                            'post_id' => $post->id,
                            'subscriber_id' => $subscriber->id,
                        ];
                    }, $postsToNotify));
    
                    foreach ($postsToNotify as $post) {
                        $subscriber->notify(new PostNotification($post));
                    }
                }
            }
        });
    
        return 0;
    }
}

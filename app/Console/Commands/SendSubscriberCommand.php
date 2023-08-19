<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\SendPost;
use App\Models\Subscriber;
use App\Notifications\PostNotification;
use Illuminate\Support\Facades\DB;
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
                $notifiedPosts = SendPost::where('subscriber_id', $subscriber->id)
                    ->pluck('post_id')
                    ->toArray();
    
                $postsToNotify = $website->posts()
                    ->whereNotIn('id', $notifiedPosts)
                    ->get();
    
                foreach ($postsToNotify as $post) {
                    DB::transaction(function () use ($post, $subscriber) {
                        $subscriber->notify(new PostNotification($post));
                        SendPost::create([
                            'post_id' => $post->id,
                            'subscriber_id' => $subscriber->id,
                        ]);
                    });
                }
            }
        });
    
        return 0;
    }
    
}

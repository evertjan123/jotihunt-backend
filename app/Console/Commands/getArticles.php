<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Article;


class getArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:Articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('retrieving articles');
        $response = Http::get('https://jotihunt.nl/api/2.0/articles');

        $articles = json_decode($response->body())->data;
        $this->info('retrieved ' . count($articles) . " clubhouses");
        
        array_map(function ($article) {
            Article::updateOrCreate(['title' => $article->title,
                                'type' => $article->type,
                                'publish_at' => $article->publish_at,
                                'message' => json_encode($article->message),
                            ]);
        }, $articles);

        $this->info('saved articles');
    }
}

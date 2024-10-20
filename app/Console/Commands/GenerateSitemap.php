<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\BlogPost;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Pagina principală
        $sitemap->add(Url::create('/')
            ->setLastModificationDate(Carbon::now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(1.0));

        // Pagina de blog
        $sitemap->add(Url::create('/blog')
            ->setLastModificationDate(Carbon::now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.9));

        // Articole de blog
        BlogPost::all()->each(function (BlogPost $post) use ($sitemap) {
            $sitemap->add(Url::create("/blog/{$post->slug}")
                ->setLastModificationDate($post->updated_at)
                ->setPriority(0.8));
        });

        // Pagini statice
        $staticPages = [
            '/despre-noi' => 0.7,
            '/contact' => 0.5,
            '/politica-de-confidentialitate' => 0.5,
            '/termeni-si-conditii' => 0.5,
        ];

        foreach ($staticPages as $page => $priority) {
            $sitemap->add(Url::create($page)
                ->setLastModificationDate(Carbon::now())
                ->setPriority($priority));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generat cu succes.');
    }
}
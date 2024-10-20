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
        $this->info('Începerea generării sitemap-ului...');

        $sitemap = Sitemap::create();

        // Pagina principală
        $sitemap->add(Url::create('/')
            ->setLastModificationDate(Carbon::now()));

        $this->info('Adăugată pagina principală.');

        // Pagina de blog
        $sitemap->add(Url::create('/blog')
            ->setLastModificationDate(Carbon::now()));

        $this->info('Adăugată pagina de blog.');

        // Articole de blog
        $blogPostCount = 0;
        BlogPost::all()->each(function (BlogPost $post) use ($sitemap, &$blogPostCount) {
            $sitemap->add(Url::create("/blog/{$post->slug}")
                ->setLastModificationDate($post->updated_at));
            $blogPostCount++;
        });

        $this->info("Adăugate $blogPostCount articole de blog.");

        // Pagini statice
        $staticPages = [
            '/despre-noi',
            '/contact',
            '/politica-de-confidentialitate',
            '/termeni-si-conditii',
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(Url::create($page)
                ->setLastModificationDate(Carbon::now()));
        }

        $this->info('Adăugate pagini statice.');

        $path = public_path('sitemap.xml');
        $sitemap->writeToFile($path);

        if (file_exists($path)) {
            $this->info("Sitemap generat cu succes la: $path");
            $this->info("Dimensiune fișier: " . number_format(filesize($path) / 1024, 2) . " KB");
        } else {
            $this->error("Eroare la generarea sitemap-ului.");
        }
    }
}
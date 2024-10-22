<?php

namespace App\Services;

use App\Models\Story;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FacebookService
{
    protected $pageId;
    protected $accessToken;
    protected $graphVersion;

    public function __construct()
    {
        $this->pageId = config('services.facebook.page_id');
        $this->accessToken = config('services.facebook.access_token');
        $this->graphVersion = config('services.facebook.graph_version', 'v21.0');

        Log::info('Facebook service initialized', [
            'page_id' => $this->pageId,
            'graph_version' => $this->graphVersion,
            'token_configured' => !empty($this->accessToken)
        ]);
    }

    public function testConnection()
    {
        try {
            $response = Http::get("https://graph.facebook.com/{$this->graphVersion}/{$this->pageId}", [
                'access_token' => $this->accessToken,
                'fields' => 'name,id,category'
            ]);

            if (!$response->successful()) {
                throw new \Exception('Facebook API error: ' . $response->body());
            }

            $data = $response->json();
            
            Log::info('Facebook test response', [
                'response' => $data
            ]);

            return $data;
        } catch (\Exception $e) {
            Log::error('Facebook test error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function publishStoryToFacebook(Story $story): bool
    {
        try {
            // Upload photo first
            $photoResponse = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$this->pageId}/photos", [
                'url' => $story->image_url,
                'caption' => $story->title,
                'published' => false,
                'access_token' => $this->accessToken,
            ]);

            if (!$photoResponse->successful()) {
                throw new \Exception('Failed to upload photo: ' . $photoResponse->body());
            }

            $photoData = $photoResponse->json();
            
            if (!isset($photoData['id'])) {
                throw new \Exception('No photo ID in response');
            }

            $photoId = $photoData['id'];

            // Create post with the photo
            $postResponse = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$this->pageId}/feed", [
                'message' => $this->prepareContent($story),
                'attached_media' => [['media_fbid' => $photoId]],
                'access_token' => $this->accessToken,
            ]);

            if (!$postResponse->successful()) {
                throw new \Exception('Failed to create post: ' . $postResponse->body());
            }

            $postData = $postResponse->json();

            if (!isset($postData['id'])) {
                throw new \Exception('No post ID in response');
            }

            // Update story with Facebook info
            $story->facebook_post_id = $postData['id'];
            $story->is_published_to_facebook = true;
            $story->facebook_published_at = now();
            $story->save();

            Log::info('Story published to Facebook successfully', [
                'story_id' => $story->id,
                'facebook_post_id' => $postData['id']
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Facebook publishing error', [
                'story_id' => $story->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }

    protected function prepareContent(Story $story): string
    {
        $genreString = $story->genre instanceof \App\StoryGenre ? $story->genre->value : 'nedefinit';
        $excerpt = Str::limit(strip_tags($story->content), 300);

        // Găsim blog post-ul asociat
        $blogPost = BlogPost::where('story_id', $story->id)->first();
        if (!$blogPost) {
            throw new \Exception('Blog post not found for story');
        }

        // Construim array-ul de hashtag-uri
        $hashtags = [
            '#PovestitorulMagic',
            '#PovestirePentruCopii',
            "#{$genreString}",
            '#Copii',
            '#Povești',
            '#CărțiPentruCopii',
            '#CitestePovesti',
            '#EducațieCopii'
        ];

        // Adăugăm hashtag pentru vârstă
        if ($story->age <= 3) {
            $hashtags[] = '#CopiiMici';
        } elseif ($story->age <= 6) {
            $hashtags[] = '#Preșcolari';
        } elseif ($story->age <= 12) {
            $hashtags[] = '#Școlari';
        }

        // Adăugăm emoji-uri tematice bazate pe gen
        $genreEmoji = match($genreString) {
            'Animale' => '🦁',
            'Aventură' => '🗺️',
            'Basm' => '🏰',
            'Comic' => '😄',
            'Educativ' => '📚',
            'Fantezie' => '🧙‍♂️',
            'LegendeRomanesti' => '🇷🇴',
            'PovestiridinBiblie' => '✝️',
            default => '📖'
        };

        // Construim conținutul postării
        $content = [
            // Titlu și emoji tematic
            "✨ {$story->title} {$genreEmoji}",
            
            // Excerpt
            "\n{$excerpt}",
            
            // Call to action și link - mutat imediat după content
            "\n🪄 Citește întreaga poveste magică pe site-ul nostru!",
            "🔗 " . route('blog.show', $blogPost->slug),
            
            // Detalii despre poveste
            "\n📖 Detalii despre poveste:",
            "🎭 Gen: {$genreString}",
            "👶 Vârsta recomandată: {$story->age} ani",
            "🎨 Temă: " . ($story->theme ?? 'diversă'),
            
            // Mesaj motivațional
            "\n💫 Fiecare poveste este o nouă aventură în imaginație!",
            
            // Hashtag-uri
            "\n" . implode(' ', array_unique($hashtags))
        ];

        return implode("\n", $content);
    }

    protected function truncateContent(string $content, int $limit = 2000): string
    {
        if (mb_strlen($content) <= $limit) {
            return $content;
        }

        // Găsim ultima propoziție completă înainte de limită
        $truncated = mb_substr($content, 0, $limit);
        $lastPeriod = mb_strrpos($truncated, '.');
        
        if ($lastPeriod !== false) {
            return mb_substr($content, 0, $lastPeriod + 1);
        }

        return mb_substr($content, 0, $limit - 3) . '...';
    }
}
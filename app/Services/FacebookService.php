<?php

namespace App\Services;

use App\Models\Story;
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
        $content = "{$story->title}\n\n";
        $content .= "O poveste magică pentru copii de {$story->age} ani ";
        $content .= "în genul " . ($story->genre instanceof \App\StoryGenre ? $story->genre->value : $story->genre);
        
        if ($story->theme) {
            $content .= ", cu tema: {$story->theme}";
        }
        
        $content .= "\n\n";
        $content .= $this->truncateContent($story->content, 2000);
        $content .= "\n\nCitește mai multe povești magice pe site-ul nostru: " . config('app.url');
        
        return $content;
    }

    protected function truncateContent(string $content, int $limit = 2000): string
    {
        if (mb_strlen($content) <= $limit) {
            return $content;
        }

        return mb_substr($content, 0, $limit - 3) . '...';
    }
}
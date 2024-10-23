<?php

namespace App\Models;

use App\StoryGenre;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use App\Services\FacebookService;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'age',
        'genre',
        'theme',
        'image_url',
        'has_audio',
        'audio_url',
        'is_published',
        'facebook_post_id',
        'is_published_to_facebook',
        'facebook_published_at'
    ];

    protected $casts = [
        'genre' => StoryGenre::class,
        'age' => 'integer',
        'has_audio' => 'boolean',
        'is_published' => 'boolean',
        'is_published_to_facebook' => 'boolean',
        'facebook_published_at' => 'datetime',
    ];

    public function publishToFacebook(): bool
    {
        if ($this->is_published_to_facebook) {
            return false;
        }

        try {
            $facebookService = app(FacebookService::class);
            
            if ($facebookService->publishStoryToFacebook($this)) {
                $this->is_published_to_facebook = true;
                $this->save();
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Error publishing to Facebook: ' . $e->getMessage(), [
                'story_id' => $this->id
            ]);
            return false;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Opțional: Metodă de scoping pentru filtrare după gen
    public function scopeOfGenre($query, StoryGenre $genre)
    {
        return $query->where('genre', $genre);
    }

    // Opțional: Metodă de scoping pentru filtrare după vârstă
    public function scopeForAge($query, int $age)
    {
        return $query->where('age', $age);
    }

    public function publishToBlog()
    {
        if (!$this->is_published) {
            $this->is_published = true;
            $this->save();

            $genreString = $this->genre instanceof StoryGenre ? $this->genre->value : 'nedefinit';

            BlogPost::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'content' => $this->content,
                'excerpt' => Str::limit(strip_tags($this->content), 150),
                'story_id' => $this->id,
                'published_at' => now(),
                'featured_image' => $this->image_url,
                'meta_title' => $this->title . ' - Poveste pentru copii | Povestitorul Magic',
                'meta_description' => "O poveste magică pentru copii de {$this->age} ani, în genul {$genreString}, cu tema " . 
                                      ($this->theme ?? 'diversă') . ". Citește acum pe Povestitorul Magic!"
            ]);

            return true;
        }

        return false;
    }
}
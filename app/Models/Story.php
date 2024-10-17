<?php

namespace App\Models;

use App\StoryGenre;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'title', 'content', 'age', 'genre', 'theme', 'image_url', 'is_published'];

    protected $casts = [
        'genre' => StoryGenre::class,
        'age' => 'integer',
    ];

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
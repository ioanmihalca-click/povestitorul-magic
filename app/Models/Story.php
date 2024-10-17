<?php

namespace App\Models;

use App\StoryGenre;
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
}
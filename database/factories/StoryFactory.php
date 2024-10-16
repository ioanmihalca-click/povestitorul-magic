<?php

namespace Database\Factories;

use App\Models\Story;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoryFactory extends Factory
{
    protected $model = Story::class;

    public function definition()
    {
        $genres = ['Animale', 'Aventură', 'Basm', 'Comic', 'Educativ', 'Fantezie', 'Legende Romanesti', 'Povestiri din Biblie'];
        $themes = [
            'Prietenie', 'Curaj', 'Familie', 'Natură', 'Magie', 'Călătorie', 
            'Animale vorbitoare', 'Prinți și prințese', 'Comori ascunse', 
            'Superputeri', 'Școala de magie', 'Aventuri în spațiu'
        ];
        
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(5, true),
            'age' => $this->faker->numberBetween(3, 12),
            'genre' => $this->faker->randomElement($genres),
            'theme' => $this->faker->randomElement($themes),
            'image_url' => $this->faker->imageUrl(1024, 1024, 'fantasy', true),
        ];
    }
}
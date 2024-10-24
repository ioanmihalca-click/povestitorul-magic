<?php

namespace Database\Seeders;

use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Seeder;

class SingleUserStoriesSeeder extends Seeder
{
    public function run()
    {
        
        $user = User::find(3);

        if (!$user) {
            $this->command->error('Utilizatorul nu a fost găsit. Asigurați-vă că există un utilizator cu ID-ul 1.');
            return;
        }

        // Generăm 5 povești pentru acest utilizator
        Story::factory(5)->create([
            'user_id' => $user->id,
        ]);

        $this->command->info('Au fost generate 5 povești pentru utilizatorul cu ID-ul ' . $user->id);
    }
}
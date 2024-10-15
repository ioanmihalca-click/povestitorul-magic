<?php

use App\Livewire\Dashboard;
use App\Livewire\ShowStory;
use App\Livewire\StoryGenerator;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/biblioteca-magica', Dashboard::class)->name('biblioteca-magica');
    Route::get('/povestitorulmagic', StoryGenerator::class)->name('povestitorulmagic');
    Route::get('/povestea/{story}', ShowStory::class)->name('story.show');
});

require __DIR__ . '/auth.php';

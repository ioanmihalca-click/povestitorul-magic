<?php

use App\Models\Story;
use App\Livewire\BlogIndex;
use App\Livewire\Dashboard;
use App\Livewire\ShowStory;
use App\Livewire\ShowBlogPost;
use App\Livewire\CreditPackages;
use App\Livewire\StoryGenerator;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $randomStory = Story::inRandomOrder()->first();
    return view('welcome', compact('randomStory'));
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/biblioteca-magica', Dashboard::class)->name('biblioteca-magica');
    Route::get('/povestitorulmagic', StoryGenerator::class)->name('povestitorulmagic');
    Route::get('/povestea/{story}', ShowStory::class)->name('story.show');
    Route::get('/credite', CreditPackages::class)->name('credits');
});

Route::get('/blog', BlogIndex::class)->name('blog.index');
Route::get('/blog/{slug}', ShowBlogPost::class)->name('blog.show');

require __DIR__ . '/auth.php';

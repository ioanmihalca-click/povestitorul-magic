<?php

use App\Models\Story;
use App\Livewire\BlogIndex;
use App\Livewire\Dashboard;
use App\Livewire\ShowStory;
use App\Livewire\Pages\About;
use App\Livewire\ShowBlogPost;
use App\Livewire\Pages\Contact;
use App\Livewire\CreditPackages;
use App\Livewire\StoryGenerator;
use App\Livewire\Pages\PrivacyPolicy;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\TermsAndConditions;


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

Route::get('/despre-noi', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/politica-de-confidentialitate', PrivacyPolicy::class)->name('privacy-policy');
Route::get('/termeni-si-conditii', TermsAndConditions::class)->name('terms-and-conditions');

require __DIR__ . '/auth.php';

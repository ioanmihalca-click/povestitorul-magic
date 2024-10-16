<?php

namespace App\Livewire;

use App\Models\Story;
use Pest\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Title;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Anthropic\Laravel\Facades\Anthropic;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

#[Title('Atelierul Povestitorului Magic')]
class StoryGenerator extends Component
{
    public $childAge;
    public $selectedGenre = '';
    public $selectedTheme = '';
    public $customTheme = '';
    public $generatedStory;
    public $storyTitle;

    public $availableGenres = [
        'Animale' => [
            'name' => 'Animale',
            'themes' => [
                'Prietenia dintre un caine si o pisica',
                'Aventurile unui pui de elefant',
                'Viata in ferma',
                'Calatoria unui stol de pasari migratoare',
                'O zi din viata unui urs polar'
            ]
        ],
        'Aventură' => [
            'name' => 'Aventură',
            'themes' => [
                'Calatorie in jurul lumii',
                'Vanatoare de comori',
                'Explorarea unei insule misterioase',
                'Misiune spatiala',
                'Aventuri in padure'
            ]
        ],
        'Basm' => [
            'name' => 'Basm',
            'themes' => [
                'Fat Frumos si Ileana Cosanzeana',
                'Zmeul si Printesa',
                'Petrea Voinicul',
                'Praslea cel Voinic',
                'Balaurul cel cu șapte capete',
            ]
        ],
        'Comic' => [
            'name' => 'Comic',
            'themes' => [
                'Supereroii amuzanti',
                'O zi de vara amuzanta',
                'Petrecerea animalelor din jungla',
                'Inventiile trasnite ale profesorului Hababam',
                'Concursul de farse'
            ]
        ],
        'Educativ' => [
            'name' => 'Educativ',
            'themes' => [
                'Descoperirea sistemului solar',
                'Viata in ocean',
                'Istoria dinozaurilor',
                'Cum functioneaza corpul uman',
                'Protejarea mediului inconjurator'
            ]
        ],
        'Fantezie' => [
            'name' => 'Fantezie',
            'themes' => [
                'Taramul zanelor',
                'Dragonii si cavalerii',
                'Scoala de magie',
                'Animale vorbitoare',
                'Calatorii in timp'
            ]
        ],
        'Legende Romanesti' => [
            'name' => 'Legende Romanesti',
            'themes' => [
                'Legenda lui Dragos Voda',
                'Povestea Babei Dochia',
                'Legenda Manastirii Curtea de Arges',
                'Legenda lui Bucur Ciobanul',
                'Legende cu haiduci (Iancu Jianu, Pintea Viteazul)'
            ]
        ],
        'Povestiri din Biblie' => [
            'name' => 'Povestiri din Biblie',
            'themes' => [
                'Arca lui Noe',
                'David și Goliat',
                'Iosif și frații săi',
                'Nașterea lui Isus',
                'Daniel în groapa cu lei'
            ]
        ],
    ];

    public function rules()
    {
        return [
            'childAge' => 'required|integer|min:1|max:18',
            'selectedGenre' => 'required|string',
            'selectedTheme' => 'required|string',
            'customTheme' => 'required_if:selectedTheme,custom|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'childAge.required' => 'Te rugăm să ne spui vârsta micuțului ascultător pentru a crea o poveste potrivită.',
        ];
    }

    public function updatedSelectedGenre()
    {
        $this->selectedTheme = '';
        $this->customTheme = '';
    }

    public function selectTheme($theme)
    {
        $this->selectedTheme = $theme;
        $this->customTheme = '';
    }

    public function setCustomTheme()
    {
        $this->selectedTheme = 'custom';
    }



private function saveImageLocally($imageUrl)
{
    try {
        $imageContents = file_get_contents($imageUrl);
        if ($imageContents === false) {
            throw new \Exception('Nu s-a putut descărca imaginea de la URL-ul furnizat.');
        }

        $filename = 'story_' . Str::random(10) . '.webp';
        $tempPath = storage_path('app/temp/' . $filename);
        $finalPath = 'public/images/stories/' . $filename;
        $fullFinalPath = storage_path('app/' . $finalPath);

        // Asigură-te că directoarele există
        File::ensureDirectoryExists(dirname($tempPath));
        File::ensureDirectoryExists(dirname($fullFinalPath));
        
        // Salvează imaginea temporar
        if (!file_put_contents($tempPath, $imageContents)) {
            throw new \Exception('Nu s-a putut salva imaginea temporară.');
        }

        // Optimizează imaginea
        ImageOptimizer::optimize($tempPath, $fullFinalPath);

        // Verifică dacă imaginea optimizată a fost creată cu succes și are conținut
        if (!File::exists($fullFinalPath) || File::size($fullFinalPath) == 0) {
            throw new \Exception('Nu s-a putut optimiza și salva imaginea sau fișierul rezultat este gol.');
        }

        // Șterge fișierul temporar
        File::delete($tempPath);

        return Storage::url($finalPath);
    } catch (\Exception $e) {
        Log::error('Eroare la salvarea/optimizarea imaginii WebP: ' . $e->getMessage());
        
        // Curăță fișierele în caz de eroare
        if (File::exists($tempPath)) {
            File::delete($tempPath);
        }
        if (File::exists($fullFinalPath)) {
            File::delete($fullFinalPath);
        }
        
        return $imageUrl; // Returnează URL-ul original în caz de eroare
    }
}
public function generateStory()
{
    try {
        $this->validate();

        $theme = $this->selectedTheme === 'custom' ? $this->customTheme : $this->selectedTheme;

        $this->generateStoryContent($theme);
        $imageUrl = $this->generateStoryImage($theme);

        if ($this->generatedStory && $imageUrl) {
            $story = $this->saveStory($theme, $imageUrl);
            $this->emit('storyGenerated', $story->id);
            session()->flash('message', 'Povestea și imaginea au fost generate și salvate cu succes!');
        } else {
            throw new \Exception('Nu s-a putut genera complet povestea sau imaginea.');
        }
    } catch (\Exception $e) {
        $this->handleGenerationError($e);
    }
}

private function generateStoryContent($theme)
{
    $prompt = "Generează o poveste scurtă in limba romană pentru un copil de {$this->childAge} ani. 
               Genul poveștii: {$this->selectedGenre}. 
               Tema poveștii: {$theme}.
               Includeți și un titlu potrivit pentru poveste.";

    $response = Anthropic::messages()->create([
        'model' => 'claude-3-5-sonnet-20240620',
        'max_tokens' => 1000,
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
    ]);

    $generatedContent = $response->content[0]->text;

    preg_match('/Titlu: (.+)\n\n(.+)/s', $generatedContent, $matches);
    $this->storyTitle = $matches[1] ?? 'Poveste fără titlu';
    $this->generatedStory = $matches[2] ?? $generatedContent;
}

private function generateStoryImage($theme)
{
    $imagePrompt = "O ilustrație pentru copii reprezentând o scenă dintr-o poveste de genul {$this->selectedGenre} cu tema: {$theme}. Stilul trebuie să fie potrivit pentru un copil de {$this->childAge} ani, folosind culori vii și personaje prietenoase.";

    $retries = 3;
    $imageUrl = null;
    while ($retries > 0 && $imageUrl === null) {
        try {
            $response = OpenAI::images()->create([
                'model' => 'dall-e-3',
                'prompt' => $imagePrompt,
                'n' => 1,
                'size' => '1024x1024',
                'quality' => "standard",
                'response_format' => 'url',
            ], ['timeout' => 120]);
            $imageUrl = $response->data[0]->url;
        } catch (\Exception $e) {
            $retries--;
            if ($retries === 0) {
                Log::error('Eroare la generarea imaginii după multiple încercări: ' . $e->getMessage());
                throw $e;
            }
        }
    }
    return $imageUrl;
}

private function saveStory($theme, $imageUrl)
{
    return Story::create([
        'user_id' => Auth::id(),
        'title' => $this->storyTitle,
        'content' => $this->generatedStory,
        'age' => $this->childAge,
        'genre' => $this->selectedGenre,
        'theme' => $theme,
        'image_url' => $this->saveImageLocally($imageUrl),
    ]);
}

private function handleGenerationError(\Exception $e)
{
    Log::error('Eroare la generarea poveștii sau a imaginii: ' . $e->getMessage());
    $this->addError('generation', 'A apărut o eroare la generarea poveștii sau a imaginii. Vă rugăm să încercați din nou.');
}

public function getUserCredits()
{
    return Auth::user()->credits;
}

public function getUserCreditValue()
{
    return Auth::user()->remaining_credit_value;
}

public function render()
{
    return view('livewire.story-generator', [
        'userCredits' => $this->getUserCredits(),
        'userCreditValue' => $this->getUserCreditValue(),
    ]);
}
}
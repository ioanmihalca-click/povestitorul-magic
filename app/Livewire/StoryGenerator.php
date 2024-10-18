<?php

namespace App\Livewire;

ini_set('max_execution_time', 120);

use App\Models\Story;
use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Anthropic\Laravel\Facades\Anthropic;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

#[Title('Atelierul Povestitorului Magic')]
class StoryGenerator extends Component
{
    public $childAge;
    public $selectedGenre = '';
    public $selectedTheme = '';
    public $customTheme = '';
    public $generatedStory;
    public $storyTitle;
    public $userCredits;
    public $userCreditValue;
    public $story;
    public $isGenerating = false;

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


    public function generateStory()
{
    try {
        $this->isGenerating = true;

        $this->validate();
        Log::info('Validare trecută cu succes');

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $requiredCredits = 1;

        if (!$user->hasSufficientCredits($requiredCredits)) {
            throw new \Exception('Nu aveți suficiente credite pentru a genera o poveste. Vă rugăm să achiziționați mai multe credite.');
        }
        Log::info('Verificare credite trecută cu succes');

        $theme = $this->selectedTheme === 'custom' ? $this->customTheme : $this->selectedTheme;
        Log::info('Temă selectată: ' . $theme);

        $this->generateStoryContent($theme);
        Log::info('Conținut poveste generat cu succes. Titlu: ' . $this->storyTitle);

        $imageUrl = $this->generateStoryImage($theme);
        Log::info('URL imagine generat cu succes: ' . $imageUrl);

        if (empty($this->generatedStory)) {
            throw new \Exception('Conținutul poveștii nu a fost generat.');
        }

        if (empty($imageUrl)) {
            throw new \Exception('URL-ul imaginii nu a fost generat.');
        }

        if (!$user->deductCredits($requiredCredits)) {
            throw new \Exception('A apărut o eroare la deducerea creditelor. Vă rugăm să încercați din nou.');
        }
        Log::info('Credite deduse cu succes');

        $story = $this->saveStory(
            $this->storyTitle,
            $this->generatedStory,
            $this->childAge,
            $this->selectedGenre,
            $theme,
            $imageUrl
        );

        $this->dispatch('storyGenerated', storyId: $story->id);
        $this->dispatch('creditsUpdated');
        session()->flash('message', 'Povestea și imaginea au fost generate și salvate cu succes! S-a dedus 1 credit din contul dumneavoastră.');
    } catch (\Exception $e) {
        Log::error('Eroare în generateStory: ' . $e->getMessage());
        $this->handleGenerationError($e);
    } finally {
        $this->isGenerating = false; 
    }
}

    private function generateStoryContent($theme)
    {
        $prompt = "Generează o poveste in limba romană pentru un copil de {$this->childAge} ani. 
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

        if (preg_match('/Titlu:\s*(.+?)(?:\n|\r\n)/', $generatedContent, $matches)) {
            $this->storyTitle = trim($matches[1]);
            $this->generatedStory = trim(preg_replace('/Titlu:\s*.+?(?:\n|\r\n)/', '', $generatedContent));
        } else {
            $this->storyTitle = 'Poveste fără titlu';
            $this->generatedStory = trim($generatedContent);
        }

    }



private function generateStoryImage($theme)
{
    $imagePrompt = "O ilustrație vibrantă și prietenoasă pentru copii, reprezentând o scenă dintr-o poveste de genul {$this->selectedGenre} cu tema: {$theme}. Ilustrația ar trebui să includă un peisaj detaliat, personaje prietenoase cu expresii vesele și detalii clare, îmbrăcate în costume specifice genului. Stilul artistic trebuie să fie luminos, plin de culori vii și potrivit pentru un copil de {$this->childAge} ani, cu forme rotunjite și detalii amuzante. Atmosfera ar trebui să fie caldă și primitoare, iar fundalul să reflecte tema poveștii, completând armonios scena principală.";


    $retries = 3;
    while ($retries > 0) {
        try {
            $response = OpenAI::images()->create([
                'model' => 'dall-e-3',
                'prompt' => $imagePrompt,
                'n' => 1,
                'size' => '1024x1024',
                'quality' => "standard",
            ], ['timeout' => 120]);

            $tempImageUrl = $response->data[0]->url;
            Log::info('URL imagine generat cu succes: ' . $tempImageUrl);

            // Încărcăm imaginea în Cloudinary
            $uploadedImage = Cloudinary::upload($tempImageUrl, [
                'folder' => 'povestitorul_magic',
                'public_id' => 'story_' . time() . '_' . Str::random(10),
            ]);

            $cloudinaryUrl = $uploadedImage->getSecurePath();
            Log::info('Imagine încărcată în Cloudinary: ' . $cloudinaryUrl);

            return $cloudinaryUrl;
        } catch (\Exception $e) {
            $retries--;
            Log::error('Eroare la generarea sau încărcarea imaginii (Încercarea ' . (3 - $retries) . '/3): ' . $e->getMessage());
            if ($retries === 0) {
                throw new \Exception('Nu s-a putut genera sau încărca imaginea după multiple încercări: ' . $e->getMessage());
            }
            sleep(2);
        }
    }
}

    private function saveStory($title, $content, $age, $genre, $theme, $imageUrl)
{
    try {
        $this->story = Story::create([
            'user_id' => Auth::id(),
            'title' => $title,
            'content' => $content,
            'age' => $age,
            'genre' => $genre,
            'theme' => $theme,
            'image_url' => $imageUrl,
        ]);
        Log::info('Poveste salvată cu succes. ID: ' . $this->story->id);
        return $this->story;
    } catch (\Exception $e) {
        Log::error('Eroare la salvarea poveștii: ' . $e->getMessage());
        throw $e;
    }
}

    private function handleGenerationError(\Exception $e)
    {
        Log::error('Eroare la generarea poveștii sau a imaginii: ' . $e->getMessage());
        $this->addError('generation', 'A apărut o eroare la generarea poveștii sau a imaginii. Vă rugăm să încercați din nou.');
    }

    public function mount()
    {
        $this->refreshCredits();
    }

    #[On('creditsUpdated')]
    public function refreshCredits()
    {
        $user = Auth::user();
        $this->userCredits = $user->credits;
        $this->userCreditValue = $user->remaining_credit_value;
    }

    public function render()
    {
        return view('livewire.story-generator');
    }
}
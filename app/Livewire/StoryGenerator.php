<?php

namespace App\Livewire;

use App\Models\Story;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Anthropic\Laravel\Facades\Anthropic;

class StoryGenerator extends Component
{
    public $childAge;
    public $storyGenre;
    public $storyTheme = '';
    public $useCustomTheme = false;
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
                'O zi nefericita dar amuzanta',
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
    ];

    public function rules()
    {
        return [
            'childAge' => 'required|integer|min:1|max:18',
            'storyGenre' => ['required', 'string', Rule::in(array_keys($this->availableGenres))],
            'storyTheme' => 'required_if:useCustomTheme,false|string|max:255',
            'customTheme' => 'required_if:useCustomTheme,true|string|max:255',
        ];
    }

    public function updatedStoryGenre()
    {
        $this->storyTheme = '';
        $this->customTheme = '';
        $this->useCustomTheme = false;
    }

    public function updatedUseCustomTheme()
    {
        if ($this->useCustomTheme) {
            $this->storyTheme = '';
        } else {
            $this->customTheme = '';
        }
    }

    public function generateStory()
    {
        $this->validate([
            'childAge' => 'required|integer|min:1|max:18',
            'storyGenre' => 'required|string|in:' . implode(',', array_keys($this->availableGenres)),
            'storyTheme' => 'required_if:useCustomTheme,false',
            'customTheme' => 'required_if:useCustomTheme,true',
        ]);

        $theme = $this->useCustomTheme ? $this->customTheme : $this->storyTheme;

        $prompt = "Generează o poveste scurtă pentru un copil de {$this->childAge} ani. 
                   Genul poveștii: {$this->storyGenre}. 
                   Tema poveștii: {$theme}.
                   Includeți și un titlu potrivit pentru poveste.";

        try {
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

            $story = Story::create([
                'user_id' => Auth::id(),
                'title' => $this->storyTitle,
                'content' => $this->generatedStory,
                'age' => $this->childAge,
                'genre' => $this->storyGenre,
                'theme' => $theme,
            ]);

            $this->emit('storyGenerated', $story->id);
            session()->flash('message', 'Povestea a fost generată și salvată cu succes!');
        } catch (\Exception $e) {
            Log::error('Eroare la generarea poveștii: ' . $e->getMessage());
            $this->addError('generation', 'A apărut o eroare la generarea poveștii. Vă rugăm să încercați din nou.');
        }
    }

    public function render()
    {
        return view('livewire.story-generator');
    }
}

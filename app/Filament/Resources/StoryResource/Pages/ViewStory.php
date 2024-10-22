<?php

namespace App\Filament\Resources\StoryResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use App\Services\FacebookService;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\StoryResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;


class ViewStory extends ViewRecord
{
    protected static string $resource = StoryResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')
                    ->label('Title')
                    ->size(TextEntry\TextEntrySize::Large),
                TextEntry::make('user.name')
                    ->label('Author'),
                TextEntry::make('age')
                    ->label('Recommended Age'),
                TextEntry::make('genre'),
                TextEntry::make('theme'),
                ImageEntry::make('image_url')
                    ->label('Story Image')
                    ->width(400)
                    ->height(300),
                TextEntry::make('content')
                    ->label('Story Content')
                    ->markdown()
                    ->columnSpanFull(),
            ]);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->after(function () {
                    Notification::make()
                        ->success()
                        ->title('Poveste Ștearsă')
                        ->body('Povestea a fost ștearsă cu succes.')
                        ->send();
                }),

            // Acțiunea pentru publicare pe blog
            Actions\Action::make('publishToBlog')
                ->label('Publică pe Blog')
                ->icon('heroicon-o-globe-alt')
                ->action(function () {
                    if ($this->record->publishToBlog()) {
                        Notification::make()
                            ->success()
                            ->title('Succes')
                            ->body('Povestea a fost publicată cu succes pe blog.')
                            ->send();
                    } else {
                        Notification::make()
                            ->danger()
                            ->title('Eroare')
                            ->body('Povestea este deja publicată sau nu a putut fi publicată.')
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->hidden(fn () => $this->record->is_published),

            // Test conexiune Facebook
            Actions\Action::make('testFacebookConnection')
                ->label('Test Facebook')
                ->icon('heroicon-o-bug-ant')
                ->action(function () {
                    try {
                        $facebookService = app(FacebookService::class);
                        $response = $facebookService->testConnection();

                        Log::info('Facebook test successful', [
                            'story_id' => $this->record->id,
                            'response' => $response
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Conexiune Facebook Reușită')
                            ->body('Conectat la pagina: ' . ($response['name'] ?? 'Necunoscut'))
                            ->send();
                    } catch (\Exception $e) {
                        Log::error('Facebook test failed', [
                            'story_id' => $this->record->id,
                            'error' => $e->getMessage()
                        ]);

                        Notification::make()
                            ->danger()
                            ->title('Eroare Test Facebook')
                            ->body($e->getMessage())
                            ->send();
                    }
                }),

            // Publicare pe Facebook
            Actions\Action::make('publishToFacebook')
                ->label('Publică pe Facebook')
                ->icon('heroicon-o-share')
                ->action(function () {
                    try {
                        $facebookService = app(FacebookService::class);
                        
                        if ($this->record->is_published_to_facebook) {
                            Notification::make()
                                ->warning()
                                ->title('Atenție')
                                ->body('Această poveste este deja publicată pe Facebook.')
                                ->send();
                            return;
                        }

                        if ($facebookService->publishStoryToFacebook($this->record)) {
                            Notification::make()
                                ->success()
                                ->title('Publicat pe Facebook')
                                ->body('Povestea a fost publicată cu succes pe Facebook.')
                                ->send();
                        } else {
                            throw new \Exception('Nu s-a putut publica povestea pe Facebook.');
                        }
                    } catch (\Exception $e) {
                        Log::error('Facebook publishing failed', [
                            'story_id' => $this->record->id,
                            'error' => $e->getMessage()
                        ]);

                        Notification::make()
                            ->danger()
                            ->title('Eroare la Publicare')
                            ->body($e->getMessage())
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->modalHeading('Publică pe Facebook')
                ->modalDescription('Ești sigur că vrei să publici această poveste pe Facebook?')
                ->modalSubmitActionLabel('Da, publică')
                ->hidden(fn () => $this->record->is_published_to_facebook),
        ];
    }
}
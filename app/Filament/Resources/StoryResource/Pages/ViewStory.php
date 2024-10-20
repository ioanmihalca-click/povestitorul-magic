<?php

namespace App\Filament\Resources\StoryResource\Pages;

use App\Filament\Resources\StoryResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Notifications\Notification;
use Filament\Actions;

class ViewStory extends ViewRecord
{
    protected static string $resource = StoryResource::class;

    // ... (previous code remains unchanged)

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
            Actions\Action::make('publishToBlog')
                ->label('Publica pe Blog')
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
        ];
    }
}
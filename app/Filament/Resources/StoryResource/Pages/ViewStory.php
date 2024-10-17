<?php

namespace App\Filament\Resources\StoryResource\Pages;

use App\Filament\Resources\StoryResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
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
            \Filament\Actions\Action::make('publishToBlog')
                ->label('Publica pe Blog')
                ->icon('heroicon-o-globe-alt')
                ->action(function () {
                    $this->record->update(['is_published' => true]);
                    $this->notify('success', 'Story published to blog successfully');
                })
                ->requiresConfirmation()
                ->hidden(fn () => $this->record->is_published),
        ];
    }
}
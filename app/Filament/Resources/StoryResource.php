<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Story;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->sortable(),
                Tables\Columns\TextColumn::make('genre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('theme')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('genre')
                    ->options(\App\StoryGenre::class),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published Status')
                    ->trueLabel('Published')
                    ->falseLabel('Not Published')
                    ->placeholder('All Stories'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
                   
                    Tables\Actions\Action::make('publishToBlog')
                    ->label('Publish to Blog')
                    ->icon('heroicon-o-globe-alt')
                    ->action(function (Story $record, Tables\Actions\Action $action) {
                        if ($record->publishToBlog()) {
                            Notification::make()
                                ->success()
                                ->title('Poveste publicata')
                                ->body('Povestea a fost publicata cu succes')
                                ->send();

                            $action->success();
                        } else {
                            Notification::make()
                                ->danger()
                                ->title('Publiccarea nu a reusit')
                                ->body('Povestea e deja publicata sau nu se poate publica')
                                ->send();

                            $action->failure();
                        }
                    })
                    ->requiresConfirmation()
                    ->hidden(fn(Story $record) => $record->is_published),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->after(function () {
                            Notification::make()
                                ->success()
                                ->title('Povestile au fost sterse')
                                ->body('Povestile selectate au fost sterse cu succes')
                                ->send();
                        }),
                        Tables\Actions\BulkAction::make('publishMultipleToBlog')
                        ->label('Publish Selected to Blog')
                        ->icon('heroicon-o-globe-alt')
                        ->action(function ($records, Tables\Actions\BulkAction $action) {
                            $publishedCount = 0;
                            foreach ($records as $record) {
                                if ($record->publishToBlog()) {
                                    $publishedCount++;
                                }
                            }

                            Notification::make()
                                ->success()
                                ->title('Povestile au fost publicate')
                                ->body("{$publishedCount} povesti au fost publicate pe blog.")
                                ->send();

                            $action->success();
                        })
                        ->requiresConfirmation(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('title')
                    ->size(Infolists\Components\TextEntry\TextEntrySize::Large),
                Infolists\Components\TextEntry::make('user.name')
                    ->label('Author'),
                Infolists\Components\TextEntry::make('age')
                    ->label('Recommended Age'),
                Infolists\Components\TextEntry::make('genre'),
                Infolists\Components\TextEntry::make('theme'),
                Infolists\Components\ImageEntry::make('image_url')
                    ->label('Story Image'),
                Infolists\Components\TextEntry::make('content')
                    ->markdown()
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStories::route('/'),
            'view' => Pages\ViewStory::route('/{record}'),
        ];
    }

    public static function canView(Model $record): bool
{
    return true;
}
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
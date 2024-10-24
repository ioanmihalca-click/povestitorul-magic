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
use App\Services\FacebookService;
use Illuminate\Support\Facades\Log;
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
                Tables\Columns\IconColumn::make('is_published_to_facebook')
                    ->boolean()
                    ->label('Pe Facebook'),
                Tables\Columns\TextColumn::make('facebook_published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('genre')
                    ->options(\App\StoryGenre::class),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Blog')
                    ->trueLabel('Publicat')
                    ->falseLabel('Nepublicat')
                    ->placeholder('Toate'),
                Tables\Filters\TernaryFilter::make('is_published_to_facebook')
                    ->label('Status Facebook')
                    ->trueLabel('Publicat')
                    ->falseLabel('Nepublicat')
                    ->placeholder('Toate'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),

                Tables\Actions\Action::make('publishToBlog')
                    ->label('Publică pe Blog')
                    ->icon('heroicon-o-globe-alt')
                    ->action(function (Story $record, Tables\Actions\Action $action) {
                        if ($record->publishToBlog()) {
                            Notification::make()
                                ->success()
                                ->title('Poveste publicată')
                                ->body('Povestea a fost publicată cu succes pe blog')
                                ->send();

                            $action->success();
                        } else {
                            Notification::make()
                                ->danger()
                                ->title('Publicarea nu a reușit')
                                ->body('Povestea e deja publicată sau nu se poate publica')
                                ->send();

                            $action->failure();
                        }
                    })
                    ->requiresConfirmation()
                    ->hidden(fn(Story $record) => $record->is_published),

                Tables\Actions\Action::make('publishToFacebook')
                    ->label('Publică pe Facebook')
                    ->icon('heroicon-o-share')
                    ->action(function (Story $record, Tables\Actions\Action $action) {
                        try {
                            $facebookService = app(FacebookService::class);

                            if ($record->is_published_to_facebook) {
                                Notification::make()
                                    ->warning()
                                    ->title('Atenție')
                                    ->body('Povestea este deja publicată pe Facebook')
                                    ->send();
                                return;
                            }

                            if ($facebookService->publishStoryToFacebook($record)) {
                                Notification::make()
                                    ->success()
                                    ->title('Publicat pe Facebook')
                                    ->body('Povestea a fost publicată cu succes pe Facebook')
                                    ->send();

                                $action->success();
                            } else {
                                throw new \Exception('Nu s-a putut publica povestea pe Facebook');
                            }
                        } catch (\Exception $e) {
                            Log::error('Facebook publishing error in table action', [
                                'story_id' => $record->id,
                                'error' => $e->getMessage()
                            ]);

                            Notification::make()
                                ->danger()
                                ->title('Eroare la publicare')
                                ->body($e->getMessage())
                                ->send();

                            $action->failure();
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Publică pe Facebook')
                    ->modalDescription('Ești sigur că vrei să publici această poveste pe Facebook?')
                    ->modalSubmitActionLabel('Da, publică')
                    ->hidden(fn(Story $record) => $record->is_published_to_facebook),

                Tables\Actions\Action::make('toggleFeatured')
                    ->label('Set as Featured')
                    ->icon('heroicon-o-star')
                    ->action(function (Story $record) {
                        // Dacă setăm această poveste ca featured, eliminăm featured de la celelalte
                        if (!$record->is_featured) {
                            Story::where('is_featured', true)->update(['is_featured' => false]);
                        }
                        $record->update(['is_featured' => !$record->is_featured]);

                        Notification::make()
                            ->success()
                            ->title($record->is_featured ? 'Poveste setată ca featured' : 'Poveste eliminată din featured')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Confirmare')
                    ->modalDescription(
                        fn(Story $record) =>
                        $record->is_featured
                            ? 'Ești sigur că vrei să elimini această poveste din featured?'
                            : 'Ești sigur că vrei să setezi această poveste ca featured? Acest lucru va elimina marcajul featured de la orice altă poveste.'
                    )

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->after(function () {
                            Notification::make()
                                ->success()
                                ->title('Povești șterse')
                                ->body('Poveștile selectate au fost șterse cu succes')
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('publishMultipleToBlog')
                        ->label('Publică Selectate pe Blog')
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
                                ->title('Povești publicate')
                                ->body("{$publishedCount} povești au fost publicate pe blog.")
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

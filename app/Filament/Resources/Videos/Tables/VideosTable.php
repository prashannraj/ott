<?php

namespace App\Filament\Resources\Videos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ImageColumn;

class VideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('release_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('age_rating')
                    ->searchable(),
                TextColumn::make('duration_sec')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('poster_path')
                    ->label('Poster')
                    ->circular()
                    ->size(60)
                    ->url(fn ($record) => $record->poster_url)
                    ->openUrlInNewTab(),
                ImageColumn::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->circular()
                    ->size(60)
                    ->url(fn ($record) => $record->banner_url)
                    ->openUrlInNewTab(),
                ImageColumn::make('banner_path')
                    ->label('Banner')
                    ->circular()
                    ->size(60)
                    ->url(fn ($record) => $record->thumbnail_url)
                    ->openUrlInNewTab(),
                TextColumn::make('seo_title')
                    ->searchable(),
                TextColumn::make('seo_keywords')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                SelectFilter::make('type')
                ->options([
                    'movie' => 'Movie',
                    'episode' => 'Episode',
                    'reel' => 'Reel',
                ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\VideoResource\RelationManagers\FilesRelationManager;
use App\Filament\Resources\VideoResource\RelationManagers\SubtitlesRelationManager;


class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                RichEditor::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(['movie' => 'Movie', 'episode' => 'Episode', 'reel' => 'Reel'])
                    ->required(),
                DatePicker::make('release_date'),
                TextInput::make('age_rating')
                    ->placeholder('13+, 16+, U')
                    ->maxLength(20),
                TextInput::make('duration_sec')
                    ->numeric()
                    ->label('Duration (seconds)'),
                FileUpload::make('poster_path')
                    ->label('Poster')
                    ->directory('posters')
                    ->image()
                    ->imageEditor(),
                FileUpload::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->directory('thumbnails')
                    ->image()
                    ->imageEditor(),
                FileUpload::make('banner_path')
                     ->label('Banner')
                    ->directory('banners')
                    ->image()
                    ->imageEditor(),
                TextInput::make('seo_title')
                    ->default(null),
                Textarea::make('seo_description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('seo_keywords')
                    ->default(null),
                Select::make('genres')
                        ->label('Genres')
                        ->multiple()
                        ->relationship('genres', 'name')
                        ->preload()
                        ->searchable(),
                Select::make('categories')
                        ->label('Categories')
                        ->multiple()
                        ->relationship('categories', 'name')
                        ->preload()
                        ->searchable(),

            ]);
    }
    // public static function getRelations(): array
    // {
    //     return [
    //         FilesRelationManager::class,
    //         SubtitlesRelationManager::class,
    //     ];
    // }
}

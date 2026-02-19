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
                    ->maxParallelUploads(1)
                    ->directory('posters')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->required()
                    ->imagePreviewHeight(300)
                    ->helperText('सिफारिस: 600×900 px, JPG/PNG/WebP'),
                FileUpload::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->maxParallelUploads(1)
                    ->directory('thumbnails')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->directory('thumbnails')
                    ->imagePreviewHeight(150)
                    ->helperText('Video preview को लागि, 1280×720 सिफारिस'),
                FileUpload::make('banner_path')
                    ->label('Banner')
                    ->maxParallelUploads(1)
                    ->directory('banners')
                    ->image()
                    ->imageEditor()
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth(1920)
                    ->imageResizeTargetHeight(1080)
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->directory('banners')
                    ->required()
                    ->imagePreviewHeight(200)
                    ->helperText('सिफारिस: 1920×1080 px, wide banner'),
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

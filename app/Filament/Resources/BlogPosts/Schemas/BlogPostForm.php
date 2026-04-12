<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('excerpt')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('banner_image')
                    ->label('Banner Image')
                    ->directory('blog-banners')
                    ->image(),
                TextInput::make('seo_title')
                    ->default(null),
                Textarea::make('seo_description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('seo_keywords')
                    ->default(null),
                DateTimePicker::make('published_at'),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
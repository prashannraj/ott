<?php

namespace App\Filament\Resources\TvShows\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TvShowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('poster_path')
                    ->default(null),
                TextInput::make('banner_path')
                    ->default(null),
                TextInput::make('age_rating')
                    ->default(null),
                TextInput::make('total_seasons')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('seo_title')
                    ->default(null),
                Textarea::make('seo_description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('seo_keywords')
                    ->default(null),
            ]);
    }
}

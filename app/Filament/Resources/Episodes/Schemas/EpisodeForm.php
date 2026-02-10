<?php

namespace App\Filament\Resources\Episodes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EpisodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('season_id')
                    ->required()
                    ->numeric(),
                TextInput::make('video_id')
                    ->required()
                    ->numeric(),
                TextInput::make('episode_number')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->default(null),
            ]);
    }
}

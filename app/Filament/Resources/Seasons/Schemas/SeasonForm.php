<?php

namespace App\Filament\Resources\Seasons\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SeasonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tv_show_id')
                    ->required()
                    ->numeric(),
                TextInput::make('season_number')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->default(null),
            ]);
    }
}

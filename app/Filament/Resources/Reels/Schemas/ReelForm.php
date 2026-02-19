<?php

namespace App\Filament\Resources\Reels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('video_id')
                    ->required()
                    ->numeric(),
                Toggle::make('is_vertical')
                    ->required(),
                TextInput::make('max_length_sec')
                    ->required()
                    ->numeric()
                    ->default(60),
            ]);
    }
}

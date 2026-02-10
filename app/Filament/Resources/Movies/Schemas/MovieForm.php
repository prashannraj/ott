<?php

namespace App\Filament\Resources\Movies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;


class MovieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('video_id')
                ->label('Video')
                ->relationship('video', 'title')
                ->searchable()
                ->required(),
                Toggle::make('is_premium')
                ->label('Requires Subscription / Paid')
                ->default(true),
                Toggle::make('allow_download')
                ->default(false),
            ]);
    }
}

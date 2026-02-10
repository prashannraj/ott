<?php

namespace App\Filament\Resources\LiveChannels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class LiveChannelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                FileUpload::make('logo_path')
                ->label('Logo')
                ->directory('channel-logos')
                ->image(),
                Select::make('category_id')
                ->label('Category')
                ->relationship('category', 'name')
                ->searchable()
                ->nullable(),
                TextInput::make('language')
                    ->default(null),
                Toggle::make('is_premium')
                ->label('Premium channel?')
                ->default(true),
            ]);
    }
}

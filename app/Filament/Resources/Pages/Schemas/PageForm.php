<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->default(true),
                    ]),
                Section::make('SEO Metadata')
                    ->schema([
                        TextInput::make('meta_title'),
                        Textarea::make('meta_description')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),
            ]);
    }
}

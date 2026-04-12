<?php

namespace App\Filament\Resources\Videos\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class SubtitlesRelationManager extends RelationManager
{
    protected static string $relationship = 'Subtitles';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('language_code')
                ->required()
                ->maxLength(10),
                TextInput::make('label')
                ->required()
                ->maxLength(50),
                FileUpload::make('file_path')
                ->label('Subtitle File (.vtt/.srt)')
                ->directory('subtitles')
                ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Subtitle')
            ->columns([
            TextColumn::make('language_code'),
            TextColumn::make('label'),
            TextColumn::make('file_path')->limit(40),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

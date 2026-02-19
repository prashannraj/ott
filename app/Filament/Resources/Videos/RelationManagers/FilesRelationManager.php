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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'Files';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('quality')
                ->options([
                    '240p' => '240p',
                    '360p' => '360p',
                    '480p' => '480p',
                    '720p' => '720p',
                    '1080p' => '1080p',
                ])
                ->required(),
                Select::make('format')
                ->options([
                    'hls' => 'HLS (.m3u8)',
                    'mp4' => 'MP4',
                ])
                ->default('mp4')
                ->required(),
                FileUpload::make('path')
                ->label('File (or MP4 manifest)')
                 ->disk('public')
                ->directory('videos')         // storage/app/public/videos
                ->acceptedFileTypes(['video/mp4'])
                ->maxSize(1048576) // 1GB
                ->required(),
                TextInput::make('size_bytes')
                ->numeric()
                ->label('Size (bytes)')
                ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('File')
            ->columns([
                TextColumn::make('quality')->sortable(),
                TextColumn::make('format'),
                TextColumn::make('path')->limit(40),
                TextColumn::make('size_bytes')
                ->label('Size')
                ->numeric(),

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

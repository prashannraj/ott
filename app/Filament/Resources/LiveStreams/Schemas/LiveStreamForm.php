<?php

namespace App\Filament\Resources\LiveStreams\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class LiveStreamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('live_channel_id')
                ->label('Channel')
                ->relationship('channel', 'name') // LiveStream::channel()
                ->searchable()
                ->required(),
                TextInput::make('stream_url')
                ->label('Stream URL (HLS)')
                ->required()
                ->url(),
                TextInput::make('backup_stream_url')
                ->label('Backup Stream URL')
                ->nullable()
                ->url(),
                TextInput::make('drm_key_id')
                ->label('DRM Key ID')
                ->nullable(),
                Toggle::make('is_active')
                ->label('Active?')
                ->default(true),
            ]);
    }
}

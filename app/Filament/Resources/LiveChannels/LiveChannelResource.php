<?php

namespace App\Filament\Resources\LiveChannels;

use App\Filament\Resources\LiveChannels\Pages\CreateLiveChannel;
use App\Filament\Resources\LiveChannels\Pages\EditLiveChannel;
use App\Filament\Resources\LiveChannels\Pages\ListLiveChannels;
use App\Filament\Resources\LiveChannels\Schemas\LiveChannelForm;
use App\Filament\Resources\LiveChannels\Tables\LiveChannelsTable;
use App\Models\LiveChannel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LiveChannelResource extends Resource
{
    protected static ?string $model = LiveChannel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Live TV';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return LiveChannelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LiveChannelsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLiveChannels::route('/'),
            'create' => CreateLiveChannel::route('/create'),
            'edit' => EditLiveChannel::route('/{record}/edit'),
        ];
    }
}

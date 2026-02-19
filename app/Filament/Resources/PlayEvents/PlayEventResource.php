<?php

namespace App\Filament\Resources\PlayEvents;

use App\Filament\Resources\PlayEvents\Pages\CreatePlayEvent;
use App\Filament\Resources\PlayEvents\Pages\EditPlayEvent;
use App\Filament\Resources\PlayEvents\Pages\ListPlayEvents;
use App\Filament\Resources\PlayEvents\Schemas\PlayEventForm;
use App\Filament\Resources\PlayEvents\Tables\PlayEventsTable;
use App\Models\PlayEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlayEventResource extends Resource
{
    protected static ?string $model = PlayEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'User Documents';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PlayEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlayEventsTable::configure($table);
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
            'index' => ListPlayEvents::route('/'),
            'create' => CreatePlayEvent::route('/create'),
            'edit' => EditPlayEvent::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\ViewHistories;

use App\Filament\Resources\ViewHistories\Pages\CreateViewHistory;
use App\Filament\Resources\ViewHistories\Pages\EditViewHistory;
use App\Filament\Resources\ViewHistories\Pages\ListViewHistories;
use App\Filament\Resources\ViewHistories\Schemas\ViewHistoryForm;
use App\Filament\Resources\ViewHistories\Tables\ViewHistoriesTable;
use App\Models\ViewHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ViewHistoryResource extends Resource
{
    protected static ?string $model = ViewHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'User Documents';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ViewHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ViewHistoriesTable::configure($table);
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
            'index' => ListViewHistories::route('/'),
            'create' => CreateViewHistory::route('/create'),
            'edit' => EditViewHistory::route('/{record}/edit'),
        ];
    }
}

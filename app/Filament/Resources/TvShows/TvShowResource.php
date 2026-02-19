<?php

namespace App\Filament\Resources\TvShows;

use App\Filament\Resources\TvShows\Pages\CreateTvShow;
use App\Filament\Resources\TvShows\Pages\EditTvShow;
use App\Filament\Resources\TvShows\Pages\ListTvShows;
use App\Filament\Resources\TvShows\Schemas\TvShowForm;
use App\Filament\Resources\TvShows\Tables\TvShowsTable;
use App\Models\TvShow;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TvShowResource extends Resource
{
    protected static ?string $model = TvShow::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Live TV';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return TvShowForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TvShowsTable::configure($table);
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
            'index' => ListTvShows::route('/'),
            'create' => CreateTvShow::route('/create'),
            'edit' => EditTvShow::route('/{record}/edit'),
        ];
    }
}

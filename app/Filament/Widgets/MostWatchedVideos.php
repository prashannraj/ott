<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;  // ✅ Import
use Filament\Tables\Columns\ImageColumn; // ✅ Import
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BadgeColumn;
use App\Models\Video;


class MostWatchedVideos extends TableWidget
{   
   

    public function table(Table $table): Table
    {
        
        return $table
            ->query(
                fn (): Builder => Video::query()
                    ->withCount('viewHistories') // ✅ count relation
                    ->orderByDesc('view_histories_count') // ✅ most watched first
                    ->limit(10)
            )
            ->columns([
                //
            ImageColumn::make('thumbnail_path')
                ->label('Thumbnail')
                ->size(60)
                ->circular()
                ->url(fn ($record) => $record->banner_url),

            TextColumn::make('title')
                ->label('Title')
                ->searchable()
                ->sortable(),

            TextColumn::make('view_histories_count') // ✅ correct column
                    ->label('Views')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}

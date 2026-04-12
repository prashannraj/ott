<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class LatestUsers extends TableWidget
{
    

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::query())
            ->columns([
                //
            ImageColumn::make('avatar')
                ->label('Avatar')
                ->size(40)
                ->defaultImageUrl(asset('icons/avatar.png')),

            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable()->sortable(),
            TextColumn::make('role')->label('Role')->sortable(),
        
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

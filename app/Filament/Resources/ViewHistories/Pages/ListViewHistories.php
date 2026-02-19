<?php

namespace App\Filament\Resources\ViewHistories\Pages;

use App\Filament\Resources\ViewHistories\ViewHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListViewHistories extends ListRecords
{
    protected static string $resource = ViewHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

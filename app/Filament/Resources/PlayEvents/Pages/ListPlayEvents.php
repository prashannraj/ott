<?php

namespace App\Filament\Resources\PlayEvents\Pages;

use App\Filament\Resources\PlayEvents\PlayEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlayEvents extends ListRecords
{
    protected static string $resource = PlayEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

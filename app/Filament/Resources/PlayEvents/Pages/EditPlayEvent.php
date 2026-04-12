<?php

namespace App\Filament\Resources\PlayEvents\Pages;

use App\Filament\Resources\PlayEvents\PlayEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlayEvent extends EditRecord
{
    protected static string $resource = PlayEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

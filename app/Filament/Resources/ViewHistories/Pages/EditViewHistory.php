<?php

namespace App\Filament\Resources\ViewHistories\Pages;

use App\Filament\Resources\ViewHistories\ViewHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditViewHistory extends EditRecord
{
    protected static string $resource = ViewHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

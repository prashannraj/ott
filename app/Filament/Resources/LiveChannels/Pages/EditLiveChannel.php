<?php

namespace App\Filament\Resources\LiveChannels\Pages;

use App\Filament\Resources\LiveChannels\LiveChannelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLiveChannel extends EditRecord
{
    protected static string $resource = LiveChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

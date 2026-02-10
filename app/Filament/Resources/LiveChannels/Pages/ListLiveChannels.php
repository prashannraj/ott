<?php

namespace App\Filament\Resources\LiveChannels\Pages;

use App\Filament\Resources\LiveChannels\LiveChannelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLiveChannels extends ListRecords
{
    protected static string $resource = LiveChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                Select::make('discount_type')
                    ->options(['percent' => 'Percent', 'fixed' => 'Fixed'])
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric(),
                TextInput::make('max_uses')
                    ->numeric()
                    ->default(null),
                TextInput::make('used_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('starts_at')
                ->label('Starts at'),
                DateTimePicker::make('expires_at')
                 ->label('Expires at'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}

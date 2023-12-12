<?php

namespace App\Filament\Resources\HomeAdvantageResource\Pages;

use App\Filament\Resources\HomeAdvantageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeAdvantage extends EditRecord
{
    protected static string $resource = HomeAdvantageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

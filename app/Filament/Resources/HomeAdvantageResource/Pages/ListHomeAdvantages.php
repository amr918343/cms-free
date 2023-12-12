<?php

namespace App\Filament\Resources\HomeAdvantageResource\Pages;

use App\Filament\Resources\HomeAdvantageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeAdvantages extends ListRecords
{
    protected static string $resource = HomeAdvantageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

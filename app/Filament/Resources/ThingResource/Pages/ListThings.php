<?php

namespace App\Filament\Resources\ThingResource\Pages;

use App\Filament\Resources\ThingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThings extends ListRecords
{
    protected static string $resource = ThingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

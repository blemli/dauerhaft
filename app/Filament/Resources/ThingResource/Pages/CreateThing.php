<?php

namespace App\Filament\Resources\ThingResource\Pages;

use App\Filament\Resources\ThingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateThing extends CreateRecord
{
    protected static string $resource = ThingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

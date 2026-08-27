<?php

namespace App\Filament\Resources\DeleteUsers\Pages;

use App\Filament\Resources\DeleteUsers\DeleteUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeleteUser extends CreateRecord
{
    protected static string $resource = DeleteUserResource::class;
}

<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('doctor_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('hour')
                    ->required(),
                Select::make('status')
                    ->options([
            'booking' => 'Booking',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'canceled' => 'Canceled',
        ])
                    ->default('booking')
                    ->required(),
                TextInput::make('cause'),
                TextInput::make('service_id')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('information')
                    ->columnSpanFull(),
            ]);
    }
}

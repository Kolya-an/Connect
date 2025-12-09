<?php

namespace App\Filament\Resources\Appointments\Tables;

use App\Models\Appointment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_fullname')
                    ->label('Пацієнт')
                    ->url(fn ($record) => route('admin.user.profile', $record->id))
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(fn($record) =>
                        ($record->user?->name ?? '') . ' ' . ($record->pacient?->second_name ?? '')
                    ),
                TextColumn::make('doctor_fullname')
                    ->label('Лікар')
                    ->getStateUsing(fn($record) =>
                        ($record->doctor->user->name ?? '') . ' ' . ($record->doctor?->second_name ?? '')
                    )
                    ->url(fn ($record) => route('admin.doctor.profile', $record->id))
                    ->searchable()
                    ->sortable(),
                //TextColumn::make('debug')->getStateUsing(fn($record)=> dd($record->doctor->toArray())),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('hour')
                    ->time()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Статус')
                    ->colors([
                        'warning' => 'booking',
                        'info'    => 'confirmed',
                        'success' => 'completed',
                        'danger'  => 'canceled',
                    ])
                    ->formatStateUsing(fn(string $state) => [
                        'booking'   => 'Бронювання',
                        'confirmed' => 'Підтверджено',
                        'completed' => 'Завершено',
                        'canceled'  => 'Відмінено'
                    ][$state]),
                TextColumn::make('cause')
                    ->label('Інформація')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('service.name')
                    ->label('Процедура')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('review.text')
                    ->label('Відгук')
                    ->placeholder('Немає відгуку') // Відображає, якщо 'review' або 'review.text' порожнє
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
              //  EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

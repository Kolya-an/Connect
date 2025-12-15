<?php

namespace App\Filament\Resources\DoctorPromotions\Tables;

use App\Models\Doctor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DoctorPromotionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor_full_name')
                    ->label('Лікар')
                    ->state(function ($record): ?string {
                        $name = $record->doctor?->user?->name;
                        $secondName = $record->doctor?->second_name;

                        if ($name || $secondName) {
                            return trim("{$name} {$secondName}");
                        }
                        return null;
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        // Используем whereHas для поиска по фамилии через цепочку связей:
                        // reviews -> appointment -> doctor
                        return $query->whereHas('doctor', function (Builder $q) use ($search) {
                            $q->where('second_name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(false),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable(),
                TextColumn::make('old_price')
                    ->label('Стара ціна')
                    ->numeric(),
                TextColumn::make('new_price')
                    ->label('Нова ціна')
                    ->numeric(),
                TextColumn::make('date_from')
                    ->label('Початок')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_to')
                    ->label('Кінець')
                    ->date()
                    ->sortable(),
            ])
            ->filters([

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

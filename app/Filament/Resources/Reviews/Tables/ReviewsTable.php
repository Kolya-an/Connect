<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ToggleColumn; 
use Filament\Tables\Filters\TernaryFilter;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor_full_name')
                    ->label('Доктор')
                    ->state(function ($record): ?string {
                        // appointment -> doctor -> user -> name
                        $name = $record->appointment?->doctor?->user?->name;
                        // appointment -> doctor -> second_name
                        $secondName = $record->appointment?->doctor?->second_name;

                        if ($name || $secondName) {
                            return trim("{$name} {$secondName}");
                        }
                        return null;
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        // Используем whereHas для поиска по фамилии через цепочку связей:
                        // reviews -> appointment -> doctor
                        return $query->whereHas('appointment.doctor', function (Builder $q) use ($search) {
                            $q->where('second_name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(false),
                TextColumn::make('medical')
                    ->label('Процедура')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('service')
                    ->label('Сервіс')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('active')
                    ->label('Активний'),

            ])
            ->filters([
                TernaryFilter::make('active')
                    ->label('Статус активності'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

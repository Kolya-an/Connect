<?php

namespace App\Filament\Resources\PhotoConsents\Tables;

use App\Models\PhotoConsent;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class PhotoConsentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('token')->label('Токен')->searchable(),
                TextColumn::make('status')
    ->label('Статус')
    ->badge()
    ->formatStateUsing(function ($state): string {
        $value = is_object($state) ? ($state->value ?? (string) $state) : (string) $state;

        return match ($value) {
            'pending' => 'Очікує',
            'signed' => 'Підписано',
            'declined' => 'Активний',
            default    => $value,
        };
    })
    ->color(function ($state): string {
        $value = is_object($state) ? ($state->value ?? (string) $state) : (string) $state;

        return match ($value) {
            'pending'  => 'danger',
            'signed'   => 'warning',
            'declined' => 'success',
            default    => 'gray',
        };
    }),
                TextColumn::make('created_at')->label('Створено')->dateTime('d.m.Y H:i'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'pending' => 'Очікує',
                        'signed' => 'Підписано',
                        'declined' => 'Активний',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('download_pdf')
                    ->label('Завантажити PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn (PhotoConsent $record) => !empty($record->pdf_path))
                    ->url(fn (PhotoConsent $record) => Storage::url($record->pdf_path))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
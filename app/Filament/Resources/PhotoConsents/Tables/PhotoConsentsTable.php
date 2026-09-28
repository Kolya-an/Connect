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
                TextColumn::make('status')->label('Статус')->badge(),
                TextColumn::make('created_at')->label('Створено')->dateTime('d.m.Y H:i'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'pending' => 'Очікує',
                        'signed' => 'Підписано',
                        'rejected' => 'Відхилено',
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
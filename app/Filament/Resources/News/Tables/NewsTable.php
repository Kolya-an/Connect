<?php

namespace App\Filament\Resources\News\Tables;

//use Filament\Tables\Actions\Action;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Mail\NewsToSubscribersMail;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use App\Models\Subscriber;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('categories.title')
                    ->label('Categories')
                    ->limit(30)
                    ->badge(),
                IconColumn::make('status')
                    ->label('Опубліковано?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Дата створення')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата оновлення')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('categories', 'title')
                    ->label('Категорія'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('sendToSubscribers')
                    ->label('Відправити підписникам')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        $emails = Subscriber::query()
                            ->whereNotNull('email')
                            ->pluck('email')
                            ->unique();

                        foreach ($emails as $email) {
                            Mail::to($email)->queue(
                                new NewsToSubscribersMail($record)
                            );
                        }

                        Notification::make()
                            ->title('Новину відправлено підписникам')
                            ->success()
                            ->send();
                    }),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('sendSelectedToSubscribers')
                        ->label('Відправити підписникам')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records, BulkAction $action) {

                            // Только опубликованные
                            $newsItems = $records->where('status', true);

                            if ($newsItems->isEmpty()) {
                                Notification::make()
                                    ->title('Немає опублікованих новин')
                                    ->warning()
                                    ->send();

                                return;
                            }

                            $emails = Subscriber::query()
                                ->whereNotNull('email')
                                ->pluck('email')
                                ->unique()
                                ->values();

                            $total = $newsItems->count() * $emails->count();
                            $sent = 0;

                            foreach ($newsItems as $news) {
                                foreach ($emails as $email) {
                                    Mail::to($email)->send(
                                        new NewsToSubscribersMail($news)
                                    );

                                    $sent++;

                                    // ⬇️ обновляем прогресс
                                    $action->setProgress(
                                        intval(($sent / $total) * 100)
                                    );
                                }
                            }

                            Notification::make()
                                ->title('Розсилка завершена')
                                ->body("Відправлено {$sent} листів")
                                ->success()
                                ->send();
                        }),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

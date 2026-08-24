<?php

namespace App\Filament\Pages;

use App\Models\Doctor;
use App\Models\DoctorPromotion;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\HomepageSetting;
use App\Models\News;
use BackedEnum;
use Filament\Schemas\Components\Section;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class HomepageSettings extends Page
{
    //protected string $view = 'filament.pages.homepage-settings';
    protected static string | UnitEnum | null $navigationGroup = 'Сторінки';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static string | BackedEnum | null $activeNavigationIcon = 'heroicon-s-home';
    protected static ?string $navigationLabel = 'Головна сторінка';

    protected static ?string $title = 'Налаштування головної сторінки';

    protected static ?string $label = "головна";

    public ?array $data = [];

    public ?HomepageSetting $record = null;
    use InteractsWithForms;
    //public ?array $data = [];

    public function getView(): string
    {
        return 'filament.pages.homepage-settings';
    }

    public function mount(): void
    {
        $this->record = HomepageSetting::firstOrCreate([]);
        $this->form->fill($this->record->toArray());
    }
    /*public function afterMount(): void
    {
        if ($this->record) {
            $this->form->fill($this->record->toArray());
        }
    }*/
    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->model($this->record)
            ->components([
                Section::make('Процедури в пошук')
                    ->schema([
                        Select::make('service_display_type')
                            ->label('Які процедури обрати?')
                            ->options([
                                'latest' => 'Останні',
                                'manual' => 'Обрати',
                            ])
                            ->reactive(),

                        TextInput::make('service_limit')
                            ->numeric()
                            ->minValue(1)
                            ->default(4)
                            ->visible(fn ($get) => $get('service_display_type') == 'latest')
                            ->label('Кількість процедур'),

                        Select::make('manual_service_ids')
                            ->multiple()
                            ->visible(fn ($get) => $get('service_display_type') === 'manual')
                            ->options(Service::query()->pluck('name', 'id'))
                            ->label('Обрати процедури'),
                    ]),

                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->maxLength(255),
                        TextInput::make('about_name')
                            ->label('Назва компанії в Про нас')
                            ->maxLength(255),
                        TextInput::make('about_title')
                            ->label('Заголовок в Про нас')
                            ->maxLength(255),
                        RichEditor::make('about_text')
                            ->label('Текст в Про нас'),

                    ]),

                Section::make('Процедури в блок')
                    ->schema([
                        Select::make('procedure_display_type')
                            ->label('Які процедури обрати?')
                            ->options([
                                'latest' => 'Останні',
                                'manual' => 'Обрати',
                            ])
                            ->reactive(),

                        TextInput::make('procedure_limit')
                            ->numeric()
                            ->minValue(1)
                            ->default(9)
                            ->visible(fn ($get) => $get('procedure_display_type') == 'latest')
                            ->label('Кількість процедур'),

                        Select::make('manual_procedure_ids')
                            ->multiple()
                            ->visible(fn ($get) => $get('procedure_display_type') === 'manual')
                            ->options(Service::query()->pluck('name', 'id'))
                            ->label('Обрати процедури'),
                    ]),

                Section::make('Блок новостей')
                    ->schema([
                        Select::make('news_display_type')
                            ->label('Які новини обрати?')
                            ->options([
                                'latest' => 'Останні',
                                'manual' => 'Обрати',
                            ])
                            ->reactive(),

                        TextInput::make('news_limit')
                            ->numeric()
                            ->minValue(1)
                            ->default(3)
                            ->visible(fn ($get) => $get('news_display_type') !== 'manual')
                            ->label('Кількість новин'),

                        Select::make('manual_news_ids')
                            ->multiple()
                            ->visible(fn ($get) => $get('news_display_type') === 'manual')
                            ->options(News::query()->pluck('title', 'id'))
                            ->label('Выбрать новости вручную'),
                    ]),

                Select::make('doctor_id')
                    ->label('Лікар')
                    ->options(
                        Doctor::with('user')
                            ->get()
                            ->mapWithKeys(fn ($doctor) => [
                                $doctor->id => "{$doctor->user->name} {$doctor->second_name}"
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => $state),

                Select::make('doctors_ids')
                    ->label('Лікарі')
                    ->multiple()
                    ->options(
                        Doctor::with('user')
                            ->get()
                            ->mapWithKeys(fn ($doctor) => [
                                $doctor->id => "{$doctor->user->name} {$doctor->second_name}"
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => $state),

                Select::make('promotion_id')
                    ->label('Акція лікаря')
                    ->options(function () {
                        return DoctorPromotion::with(['doctor.user'])
                            ->get()
                            ->mapWithKeys(function ($promotion) {
                                $doctor = $promotion->doctor;
                                $user = $doctor?->user;
                                $title = $promotion->title ?? '—';
                                $secondName = $doctor?->second_name ?? '—';
                                $userName = $user?->name ?? '—';

                                return [
                                    $promotion->id => "{$title} — {$secondName} {$userName}"
                                ];
                            });
                    })
                    ->searchable()
                    ->required(),

                Section::make('Дисклеймер')
                    ->schema([
                        RichEditor::make('disclamer')
                            ->label('Текст дисклеймер'),
                        

                    ]),
            ]);

    }
    public function save(): void
    {
        $data = $this->form->getState();

        if (! $this->record) {
            $this->record = new HomepageSetting();
        }

        $this->record->fill($data)->save();

        Notification::make()
            ->title('Настройки успешно сохранены!')
            ->success()
            ->send();
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('💾 Сохранить изменения')
                ->color('primary')
                ->action('save'),
        ];
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Doctor;

class PhotoSearchForm extends Component
{
    public $query = '';
    public $services = [];
    public $doctors = [];
    public $serviceId = null;
    public $selectedDoctorId = null;
    public $radius = 5;
    public $city = '';
    public $search = '';
    public $rating = '';
    public $sex = '';
    public $area = '';
    public $areaSearch = '';
    public $areas = [];
    public $priceFrom;
    public $priceTo;
    public $discount = false;
    public $at_home = false;
    public $gift = false;

    public $showDropdown = false;
    public $showAreaDropdown = false;
    public $allCities = [
        // Областные центры и крупные города
        'Київ', 'Харків', 'Одеса', 'Дніпро', 'Донецьк', 'Запоріжжя', 'Львів', 'Кривий Ріг',
        'Миколаїв', 'Маріуполь', 'Луганськ', 'Вінниця', 'Севастополь', 'Сімферополь',
        'Херсон', 'Полтава', 'Чернігів', 'Черкаси', 'Житомир', 'Хмельницький', 'Чернівці',
        'Рівне', 'Івано-Франківськ', 'Кам\'янське', 'Кропивницький', 'Тернопіль', 'Кременчук',
        'Луцьк', 'Біла Церква', 'Ужгород', 'Мелітополь', 'Нікополь', 'Слов\'янськ',
        'Бердянськ', 'Алчевськ', 'Павлоград', 'Суми', 'Северодонецьк', 'Горлівка',
        'Лисичанськ', 'Євпаторія', 'Ялта', 'Дрогобич', 'Мукачево', 'Конотоп', 'Умань',
        'Шостка', 'Бровари', 'Ізмаїл', 'Олександрія', 'Енергодар', 'Ковель', 'Костянтинівка',
        'Нова Каховка', 'Феодосія', 'Стрий', 'Коломия', 'Сміла', 'Чернівці',
        'Сніжне', 'Харцизьк', 'Рубіжне', 'Дружківка', 'Новомосковськ', 'Торецьк', 'Часів Яр',
        'Хуст', 'Ірміно', 'Брянка', 'Новоград-Волинський', 'Лозова', 'Антрацит', 'Свердловськ',
        'Ровеньки', 'Жовті Води', 'Макіївка', 'Сєвєродонецьк', 'Красний Луч', 'Стаханов',

        // Другие города А - Я
        'Авангард', 'Авдіївка', 'Алмазна', 'Алупка', 'Алушта', 'Амвросіївка', 'Ананьїв',
        'Андрушівка', 'Аннівка', 'Апостолове', 'Армянськ', 'Арциз', 'Бахмач', 'Бахмут',
        'Баштанка', 'Белз', 'Бердичів', 'Берегове', 'Бережани', 'Березань', 'Березне',
        'Березівка', 'Бобринець', 'Бобровиця', 'Богодухів', 'Богуслав', 'Болград', 'Болехів',
        'Борзна', 'Борислав', 'Бориспіль', 'Борщів', 'Боярка', 'Бунге', 'Бурштин', 'Буринь',
        'Бусіна', 'Валуйки', 'Валки', 'Василівка', 'Вашківці', 'Великі Мости', 'Верхньодніпровськ',
        'Вижниця', 'Вилкове', 'Винники', 'Волочиськ', 'Ворожба', 'Вугледар', 'Гадяч', 'Гайворон',
        'Гайсин', 'Глиняни', 'Гнівань', 'Гола Пристань', 'Горішні Плавні', 'Городенка',
        'Городище', 'Городня', 'Городок', 'Гребінка', 'Гуляйполе', 'Дебальцеве', 'Деражня',
        'Дергачі', 'Джанкой', 'Добромиль', 'Добропілля', 'Докучаєвськ', 'Долина', 'Долинська',
        'Дружба', 'Дубно', 'Дубровиця', 'Дунаївці', 'Есмань', 'Єнакієве', 'Жашків', 'Залізне',
        'Заставна', 'Збараж', 'Зборів', 'Здолбунів', 'Зимогір\'я', 'Зіньків', 'Зміїв', 'Знам\'янка',
        'Золоте', 'Золотоноша', 'Зоринськ', 'Іванівка', 'Іллінці', 'Іловайськ', 'Інкерман',
        'Іршава', 'Ічня', 'Кагарлик', 'Кадіївка', 'Калинівка', 'Калуш', 'Камінь-Каширський',
        'Кам\'янець-Подільський', 'Кам\'янка', 'Кам\'янка-Бузька', 'Кам\'янка-Дніпровська',
        'Канів', 'Карлівка', 'Каховка', 'Керч', 'Кипуче', 'Ківерці', 'Кілія', 'Кобеляки',
        'Кодима', 'Козятин', 'Комарно', 'Конотоп', 'Копичинці', 'Корець', 'Коростень',
        'Коростишів', 'Корсунь-Шевченківський', 'Корюківка', 'Косів', 'Костопіль', 'Краматорськ',
        'Красилів', 'Красногорівка', 'Кременець', 'Крижопіль', 'Кролевець', 'Курахове',
        'Ладижин', 'Ланівці', 'Лебедин', 'Лиман', 'Липовець', 'Лубни', 'Любомль', 'Люботин',
        'Мала Виска', 'Малин', 'Мар\'їнка', 'Мена', 'Мерефа', 'Миронівка', 'Могилів-Подільський',
        'Молодогвардійськ', 'Молочанськ', 'Монастириська', 'Монастирище', 'Моспине', 'Мостиська',
        'Мукачево', 'Надвірна', 'Немирів', 'Нетішин', 'Ніжин', 'Нова Одеса', 'Новоазовськ',
        'Новоград-Волинський', 'Новогродівка', 'Новодністровськ', 'Новодружеськ', 'Новомиргород',
        'Новомосковськ', 'Новоселиця', 'Новоукраїнка', 'Новояворівськ', 'Носівка', 'Обухів',
        'Овруч', 'Одеса', 'Олевськ', 'Олександрівськ', 'Оріхів', 'Остер', 'Острог', 'Охтирка',
        'Очаків', 'П\'ятихатки', 'Первомайськ', 'Перевальськ', 'Перемишляни', 'Перечин',
        'Перещепине', 'Переяслав', 'Першотравенськ', 'Петрово-Красносілля', 'Пирятин',
        'Підгайці', 'Підгородне', 'Погребище', 'Подільськ', 'Покров', 'Покровськ', 'Пологи',
        'Полонне', 'Помічна', 'Привілля', 'Прилуки', 'Приморськ', 'Прип\'ять', 'Пустомити',
        'Путивль', 'Рава-Руська', 'Радехів', 'Радивилів', 'Рахів', 'Рені', 'Решетилівка',
        'Ржищів', 'Родінське', 'Рожище', 'Роздільна', 'Саки', 'Самбір', 'Сарни', 'Свалява',
        'Сватове', 'Світловодськ', 'Світлодарськ', 'Седнів', 'Селидове', 'Семенівка',
        'Середина-Буда', 'Синельникове', 'Скадовськ', 'Скалат', 'Сквира', 'Сколе', 'Славута',
        'Славутич', 'Слов\'яносербськ', 'Сміла', 'Снігурівка', 'Сокаль', 'Сокиряни', 'Соледар',
        'Старий Крим', 'Старий Самбір', 'Старобільськ', 'Старокостянтинів', 'Стебник',
        'Сторожинець', 'Стрий', 'Судак', 'Судова Вишня', 'Таврійськ', 'Тальне', 'Тараща',
        'Татарбунари', 'Теплик', 'Теребовля', 'Тетіїв', 'Тисмениця', 'Тлумач', 'Токмак',
        'Тростянець', 'Трускавець', 'Тульчин', 'Турка', 'Тячів', 'Угнів', 'Узин', 'Українка',
        'Українськ', 'Устилуг', 'Фастів', 'Федорівка', 'Ходорів', 'Хотин', 'Христинівка',
        'Хust', 'Цюрупинськ', 'Червоноград', 'Червоноармійськ', 'Червонопартизанськ',
        'Чоп', 'Чуднів', 'Шахтарськ', 'Шепетівка', 'Шпола', 'Щолкіне', 'Южне', 'Юнокомунівськ',
        'Яворів', 'Ялта', 'Ямпіль', 'Яремче', 'Ясинувата'
    ];
    public $service_form; // популярные сервисы
    public $doctorQuery = ''; // Новое поле для ввода имени врача
    public $doctorResults = []; // Результаты поиска врачей
    public $showDoctorDropdown = false;
    public $more_filter = false;
    public $filteredAreas = [];
    public function mount()
    {
        $this->service_form = Service::take(5)->get(); // популярные сервисы
        $this->priceFrom = request()->get('priceFrom') ?? '';
        $this->priceTo   = request()->get('priceTo') ?? '';
        $this->city   = request()->get('city') ?? '';
        $this->area   = request()->get('area') ?? '';
        $this->areaSearch = $this->area;
        $this->discount = request()->get('discount') ?? false;
        $this->at_home = request()->get('at_home') ?? false;
        $this->gift = request()->get('gift') ?? false;
    }
    public function updated($property)
    {
        if ($property === 'query') {
            $this->performSearch();
        }
        if ($property === 'areaSearch') {
            $this->updateAreaSuggestions();
        }
    }

    public function performSearch()
    {
        if (strlen($this->query) < 2) {
            $this->services = [];
            return;
        }

        $this->services = Service::where('name', 'like', '%' . $this->query . '%')
            ->limit(5)
            ->get();

        if ($this->serviceId) {
            $selectedService = Service::find($this->serviceId);
            if ($selectedService && $selectedService->name !== $this->query) {
                $this->serviceId = null;
            }
        }
    }



    public function selectService($id, $name)
    {
        $this->serviceId = $id;
        $this->query = $name;
        $this->services = [];
    }

    public function selectPopularService($id, $name)
    {
        $this->selectService($id, $name);
    }

    public function updatedSearch($value)
    {
        if (trim($value) !== '' && $value !== $this->city) {
            $this->showDropdown = true;
        } else {
            $this->showDropdown = false;
        }

        // Если поле очищено, сбрасываем выбранный город
        if (trim($value) === '') {
            $this->city = '';
        }
    }
    public function hideDropdown()
    {
        // Не сбрасываем $search, чтобы поле ввода осталось заполненным
        $this->showDropdown = false;
    }
    public function selectCity($cityName)
    {
        $this->city = $cityName; // Сохраняем выбранный город
        $this->search = $cityName; // Обновляем поле ввода, чтобы оно показывало выбранный город
        $this->showDropdown = false; // Скрываем список
        // $this->query = $cityName; // Убрано, если $query не используется
        $this->dispatch('citySelected'); // Отправляем событие, если нужно обновить карту и врачей
    }
    public function updatedDoctorQuery($value)
    {
        // Очищаем выбранного доктора, если пользователь начал печатать заново
        $this->selectedDoctorId = null;

        if (strlen($value) > 1) {
            $this->doctorResults = Doctor::where('second_name', 'like', '%' . $value . '%')
                ->with('user')
                ->limit(10)
                ->get();

            $this->showDoctorDropdown = true;
        } else {
            $this->doctorResults = [];
            $this->showDoctorDropdown = false;
        }
    }

    public function selectDoctor($doctorId, $doctorFullName)
    {
        $this->selectedDoctorId = $doctorId;
        $this->doctorQuery = $doctorFullName; // Отображаем полное имя в поле ввода
        $this->doctorResults = [];
        $this->showDoctorDropdown = false;

        // Опционально: можно отправить событие для фокусировки карты на этом докторе
        // $this->dispatch('doctorSelected', doctorId: $doctorId);
    }
    public function searchDoctors()
    {
        // ПЕРЕДАЕМ ID ВРАЧА В ПАРАМЕТРЫ ПЕРЕНАПРАВЛЕНИЯ
        return redirect()->route('map', [
            'service_id' => $this->serviceId,
            'radius'     => $this->radius,
            'rating'     => $this->rating,
            'sex'        => $this->sex,
            'city'       => $this->city,
            'priceFrom'  => $this->priceFrom,
            'priceTo'    => $this->priceTo,
            'area'       => $this->area,
            'doctor_id'  => $this->selectedDoctorId,
            'discount'   => $this->discount ? 1 : 0,
            'gift'       => $this->gift ? 1 : 0,
            'at_home'    => $this->at_home ? 1 : 0
        ]);
    }

    public function hideDoctorDropdown()
    {
        $this->showDoctorDropdown = false;
    }
    public function openMoreFilter()
    {
        $this->more_filter = true;
    }
    public function closeMoreFilter()
    {
        $this->more_filter = false;
    }
    public function updateAreaSuggestions()
    {
        $searchTerm = trim($this->areaSearch);

        if (strlen($searchTerm) < 2) {
            $this->filteredAreas = [];
            $this->showAreaDropdown = false;
            return;
        }

        // Ищем уникальные значения area из таблицы doctors
        $this->filteredAreas = Doctor::whereNotNull('area')
            ->where('area', '!=', '')
            ->where('area', 'like', '%' . $searchTerm . '%')
            ->distinct()
            ->pluck('area')
            ->take(10)
            ->toArray();

        $this->showAreaDropdown = !empty($this->filteredAreas);
    }
    public function updatedAreaSearch($value)
    {
        $this->updateAreaSuggestions();

        if (trim($value) === '') {
            $this->area = '';
        }
    }

    public function hideAreaDropdown()
    {
        $this->showAreaDropdown = false;
    }

    public function selectArea($areaName)
    {
        $this->area = $areaName;
        $this->areaSearch = $areaName;
        $this->showAreaDropdown = false;
        $this->dispatch('areaSelected');
    }
    public function resetFilters()
    {
        // 1. Скидання властивостей до їхніх початкових/нульових значень
        $this->areaSearch = '';
        $this->sex = '';
        $this->priceFrom = null;
        $this->priceTo = null;
        $this->discount = false;
        $this->gift = false;
        $this->at_home = false;

        // 2. Додатково скидаємо пов'язані властивості
        $this->showAreaDropdown = false;

        // 3. Якщо після очищення потрібно негайно оновити список лікарів,
        // викликайте метод, який запускає пошук (якщо він не викликається автоматично)
        //$this->emitDoctors();

        // 4. (ОПЦІЙНО) Закрити блок фільтрів після очищення
        // $this->closeMoreFilter();
    }
    public function render()
    {
        $filteredCities = collect($this->allCities)
            ->filter(function ($city) {
                // Фильтруем по свойству $search, используя его как запрос
                return stripos($city, $this->search) !== false;
            })
            ->values()
            ->take(10);
        return view('livewire.photo-search-form', [
            'filteredCities' => $filteredCities,
        ]);
    }
}

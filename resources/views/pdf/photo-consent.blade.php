<!DOCTYPE html>
<html lang="uk">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Згода на використання фотоматеріалів</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            color: #1a202c;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .title {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #2d3748;
            margin: 0;
        }

        .subtitle {
            font-size: 9pt;
            color: #718096;
            margin-top: 5px;
        }

        .content {
            margin-bottom: 20px;
            text-align: justify;
        }

        .doctor-details {
            margin-bottom: 20px;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
        }

        /* Таблиця для інформації про процедуру та продукт */
        .procedure-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .procedure-info-table td {
            width: 50%;
            padding: 10px 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .info-label {
            font-size: 8pt;
            color: #718096;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 11pt;
            color: #1a202c;
            font-weight: bold;
        }

        /* Контейнер для фото ДО / ПІСЛЯ */
        .photo-container {
            text-align: center;
            margin: 20px 0;
            page-break-inside: avoid;
        }

        .photo-table {
            width: 100%;
            border-collapse: collapse;
        }

        .photo-cell {
            width: 50%;
            text-align: center;
            padding: 5px;
            vertical-align: top;
        }

        .photo-wrapper {
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 4px;
            background-color: #ffffff;
            display: inline-block;
        }

        .photo-wrapper img {
            max-width: 280px;
            max-height: 260px;
            display: block;
            margin: 0 auto;
        }

        .photo-badge {
            margin-top: 6px;
            font-size: 8pt;
            font-weight: bold;
            color: #4a5568;
            text-transform: uppercase;
        }

        /* Штамп цифрового підпису КЕП / Дія.Підпис */
        .stamp-box {
            margin-top: 30px;
            border: 2px dashed #2b6cb0;
            background-color: #ebf8ff;
            border-radius: 8px;
            padding: 12px 16px;
            page-break-inside: avoid;
        }

        .stamp-title {
            font-size: 10pt;
            font-weight: bold;
            color: #2b6cb0;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .stamp-details {
            font-size: 9pt;
            color: #2d3748;
        }

        .stamp-details td {
            padding: 2px 0;
            vertical-align: top;
        }

        .stamp-details .label {
            font-weight: bold;
            width: 140px;
            color: #4a5568;
        }

        .footer {
            margin-top: 40px;
            font-size: 8pt;
            color: #a0aec0;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

@php
    $doctorPhoto = $consent?->doctorPhoto;

    // Отримання назви процедури
    $procedureName = is_object($doctorPhoto?->procedure) 
        ? $doctorPhoto?->procedure?->name 
        : ($doctorPhoto?->procedure ?? '—');

    // Отримання назви препарату / продукту
    $productName = is_object($doctorPhoto?->product) 
        ? $doctorPhoto?->product?->name 
        : ($doctorPhoto?->product ?? '—');
@endphp

    <div class="header">
        <h1 class="title">ЗГОДА</h1>
        <div class="subtitle">на публікацію та використання фотоматеріалів</div>
    </div>

    @if(!empty($doctor))
        <div class="doctor-details">
            <strong>Лікар:</strong> 
            {{ data_get($doctor, 'name') }} {{ data_get($doctor, 'second_name') }}<br>
            
            @if(data_get($doctor, 'phone'))
                <strong>Телефон лікаря:</strong> {{ data_get($doctor, 'phone') }}
            @endif
        </div>
    @endif

    <div class="content">
        <p>
            Я, <strong>{{ $signerInfo['name'] ?? 'Згідно з даними системи' }}</strong> 
            @if(!empty($signerInfo['drfo']))
                (РНОКПП: <strong>{{ $signerInfo['drfo'] }}</strong>)
            @endif,
            цим надаю добровільну згоду на розміщення, обробку та публікацію фотографічних зображень у медичних та інформаційних цілях.
        </p>

        <p>
            Надана згода розповсюджується на використання зазначеного нижче фотоматеріалу у портфоліо лікаря, а також на офіційних інформаційних ресурсах клініки.
        </p>
    </div>

    <!-- Блок з Процедурою та Препаратом -->
    <table class="procedure-info-table">
        <tr>
            <td>
                <span class="info-label">Процедура:</span>
                <span class="info-value">{{ $procedureName }}</span>
            </td>
            <td>
                <span class="info-label">Препарат / Продукт:</span>
                <span class="info-value">{{ $productName }}</span>
            </td>
        </tr>
    </table>

    <!-- Фотографічний матеріал -->
    <div class="photo-container">
        @if(!empty($photoBeforeBase64) || !empty($photoAfterBase64))
            <table class="photo-table">
                <tr>
                    @if(!empty($photoBeforeBase64))
                        <td class="photo-cell">
                            <div class="photo-wrapper">
                                <img src="data:image/jpeg;base64,{{ $photoBeforeBase64 }}" alt="Фото ДО">
                            </div>
                            <div class="photo-badge">Фото ДО</div>
                        </td>
                    @endif

                    @if(!empty($photoAfterBase64))
                        <td class="photo-cell">
                            <div class="photo-wrapper">
                                <img src="data:image/jpeg;base64,{{ $photoAfterBase64 }}" alt="Фото ПІСЛЯ">
                            </div>
                            <div class="photo-badge">Фото ПІСЛЯ</div>
                        </td>
                    @endif
                </tr>
            </table>
        @elseif(!empty($photoBase64))
            <!-- Фоллбек для єдиного зображення -->
            <div class="photo-wrapper">
                <img src="data:image/jpeg;base64,{{ $photoBase64 }}" alt="Фотоматеріал згоди">
            </div>
        @endif

        @if(!empty($consent->doctor_photo_id))
            <div class="subtitle" style="margin-top: 8px;">Ідентифікатор фото: #{{ $consent->doctor_photo_id }}</div>
        @endif
    </div>

    <!-- Штамп електронного цифрового підпису -->
    <div class="stamp-box">
        <div class="stamp-title">✓ Підписано Електронним Підписом (КЕП / Дія.Підпис)</div>
        
        <table class="stamp-details" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="label">Підписувач:</td>
                <td><strong>{{ $signerInfo['name'] ?? '—' }}</strong></td>
            </tr>
            @if(!empty($signerInfo['drfo']))
            <tr>
                <td class="label">РНОКПП / ІПН:</td>
                <td>{{ $signerInfo['drfo'] }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Дата та час підпису:</td>
                <td>{{ $signerInfo['signed_at'] ?? now()->format('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <td class="label">Токен сесії:</td>
                <td><small>{{ $consent->token ?? '—' }}</small></td>
            </tr>
            <tr>
                <td class="label">Статус перевірки:</td>
                <td><strong>Цілісність та валідність підпису підтверджено</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Документ згенеровано автоматично системою Connect. Юридична чинність підтверджена згідно із Законом України «Про електронні довірчі послуги».
    </div>

</body>
</html>
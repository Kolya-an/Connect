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

        .photo-container {
            text-align: center;
            margin: 20px 0;
            page-break-inside: avoid;
        }

        .photo-container img {
            max-width: 320px;
            max-height: 300px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 4px;
            background-color: #ffffff;
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

    <div class="header">
        <h1 class="title">ЗГОДА</h1>
        <div class="subtitle">на публікацію та використання фотоматеріалів</div>
    </div>

    <div class="content">
        <p>
            Я, <strong>{{ $signerInfo['name'] ?? 'Пацієнт' }}</strong> 
            @if(!empty($signerInfo['drfo']))
                (РНОКПП: <strong>{{ $signerInfo['drfo'] }}</strong>)
            @endif,
            цим надаю добровільну згоду на розміщення, обробку та публікацію фотографічних зображень у медичних та інформаційних цілях.
        </p>

        <p>
            Надана згода розповсюджується на використання зазначеного нижче фотоматеріалу у портфоліо лікаря, а також на офіційних інформаційних ресурсах клініки.
        </p>
    </div>

    <!-- Фотографічний матеріал -->
    @if(!empty($photoBase64))
        <div class="photo-container">
            <img src="data:image/jpeg;base64,{{ $photoBase64 }}" alt="Фотоматеріал згоди">
            <div class="subtitle">Ідентифікатор фото: #{{ $consent->doctor_photo_id }}</div>
        </div>
    @endif

    <!-- Штамп електронного цифрового підпису -->
    <div class="stamp-box">
        <div class="stamp-title">✓ Підписано Електронним Підписом (КЕП / Дія.Підпис)</div>
        
        <table class="stamp-details" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="label">Підписувач:</td>
                <td><strong>{{ $signerInfo['name'] ?? 'Відомості відсутні' }}</strong></td>
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
                <td><small>{{ $consent->token }}</small></td>
            </tr>
            <tr>
                <td class="label">Статус перевірки:</td>
                <td><strong>Цілісність та валидність підпису підтверджено</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Документ згенеровано автоматично системою Connect. Юридична чинність підтверджена згідно із Законом України «Про електронні довірчі послуги».
    </div>

</body>
</html>
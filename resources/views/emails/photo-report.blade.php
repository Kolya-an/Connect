<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Скарга на фото</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px;">
    <h2 style="color: #d9534f;">Нова скарга на фото роботи</h2>
    
    <p><strong>Хто поскаржився:</strong> {{ $reporterName }}</p>
    <p><strong>Лікар (чиє фото):</strong> {{ $doctorName }}</p>
    
    <p><strong>Текст скарги:</strong></p>
    <blockquote style="background: #f9f9f9; padding: 12px; border-left: 4px solid #f396a2; margin: 0 0 20px 0;">
        {{ $reportText }}
    </blockquote>

    <p><strong>Посилання на фото:</strong></p>
    <ul>
        <li><strong>Фото До:</strong> <a href="{{ $photoBefore }}" target="_blank">{{ $photoBefore }}</a></li>
        <li><strong>Фото Після:</strong> <a href="{{ $photoAfter }}" target="_blank">{{ $photoAfter }}</a></li>
    </ul>
</body>
</html>
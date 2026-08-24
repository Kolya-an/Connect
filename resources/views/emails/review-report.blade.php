<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Скарга на відгук</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px;">
    <h2 style="color: #d9534f;">Нова скарга на відгук</h2>
    
    <p><strong>Хто поскаржився:</strong> {{ $reporterName }}</p>
    <p><strong>Лікар (на сторінці якого відгук):</strong> {{ $doctorName }}</p>
    
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <h3 style="color: #333;">Інформація про відгук:</h3>
    <p><strong>Дата публікації:</strong> {{ $reviewDate }}</p>
    <p><strong>Текст відгуку:</strong></p>
    <blockquote style="background: #f4f4f4; padding: 12px; border-left: 4px solid #ccc; margin: 0 0 20px 0;">
        {{ $reviewText }}
    </blockquote>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <h3 style="color: #d9534f;">Причина скарги:</h3>
    <blockquote style="background: #fff0f0; padding: 12px; border-left: 4px solid #d9534f; margin: 0;">
        {{ $reportText }}
    </blockquote>
</body>
</html>
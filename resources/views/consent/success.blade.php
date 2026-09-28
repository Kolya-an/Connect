<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Підпис успішно збережено</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 font-sans">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 text-center border border-slate-100" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);text-align:center;">
        <!-- Іконка успіху -->
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-slate-800 mb-2" style="font-size: 3.5rem; font-weight: 700;margin-bottom:20px;">Дякуємо!</h1>
        <p class="text-slate-600 mb-6">Ваш підпис успішно збережено та додано до документа.</p>

        <p class="text-sm text-slate-400">Ви можете закрити це вікно браузера.</p>
    </div>

    <script>
        // Автоматична спроба закрити вкладку через 3 секунди
        setTimeout(() => {
            window.close();
        }, 3000);
    </script>
</body>
</html>
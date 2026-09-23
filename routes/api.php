<?php

use App\Http\Controllers\DiiaWebhookController;

Route::post('/diia/webhook', [DiiaWebhookController::class, 'handle'])->name('api.diia.webhook');

// Якщо це сторінка перенаправлення пацієнта після підпису (GET)
//Route::get('/consent/callback', [DiiaWebhookController::class, 'handleCallback'])
    //->name('patient.consent.callback');

// Або якщо це Webhook від Дії для обробки статусу (POST)
//Route::post('/diia/webhook', [DiiaWebhookController::class, 'handle'])
    //->name('patient.consent.callback');


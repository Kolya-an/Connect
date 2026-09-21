<?php

use App\Http\Controllers\DiiaWebhookController;

Route::post('/diia/webhook', [DiiaWebhookController::class, 'handle'])->name('api.diia.webhook');
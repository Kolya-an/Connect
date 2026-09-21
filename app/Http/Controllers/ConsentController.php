<?php

namespace App\Http\Controllers;

use App\Models\PhotoConsent;
use Illuminate\Http\Request;

class ConsentController extends Controller
{
    public function show(string $token)
    {
        // Знаходимо згоду за токеном разом із пов'язаним фото
        $consent = PhotoConsent::with('doctorPhoto')
            ->where('token', $token)
            ->firstOrFail();

        // Повертаємо Blade-шаблон або Livewire-компонент сторінки підпису
        return view('consent.show', compact('consent'));
    }
}
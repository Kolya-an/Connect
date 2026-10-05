<?php

namespace App\Http\Controllers;

use App\Models\PhotoConsent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ConsentController extends Controller
{
    public function show(string $token): View
    {
        $consent = PhotoConsent::with(['doctorPhoto', 'doctor', 'doctorPhoto.doctor'])
            ->where('token', $token)
            ->firstOrFail();

        // Відображаємо спеціальне подання, якщо згоду вже підписано
        if ($consent->status === 'signed') {
            return view('consent.already-signed', compact('consent'));
        }

        return view('consent.show', compact('consent'));
    }
}
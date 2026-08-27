<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserCanViewProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Якщо користувач взагалі не авторизований — редиректимо на головну/логін
        if (!Auth::check()) {
            return redirect()->to('/')->with('error', __('Будь ласка, увійдіть в акаунт.'));
        }

        // 2. Якщо авторизований, але active !== 1 — розлогінюємо та викидаємо
        if ((int) Auth::user()->active !== 1) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->to('/')->with('error', __('Ваш акаунт деактивовано.'));
        }

        // 3. Перевірка доступу до чужого профілю за ID з маршруту
        $userId = $request->route('id');

        if ($userId && (int) Auth::id() !== (int) $userId) {
            abort(403, __('У вас немає доступу до цього профілю'));
        }

        return $next($request);
    }
}
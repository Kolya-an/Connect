<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Проверяем, что пользователь авторизован
        if (!auth()->check()) {
            return redirect('/login');
        }

        $userId = $request->route('id');

        // Преобразуем ID к integer для надежного сравнения
        if (auth()->id() != (int)$userId) {
            abort(403, 'У вас нет доступа к этому профилю');
        }

        return $next($request);
    }
}

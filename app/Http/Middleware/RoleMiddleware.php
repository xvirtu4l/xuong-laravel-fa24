<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $userRole = $request->user()->role; // Giả sử vai trò người dùng được lưu trong cột 'role' của bảng users
        $role = "admin";
        if ($userRole != $role) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);

    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $age = $request->user()->age;

        // Nếu không có tuổi hoặc không hợp lệ
        if (!$age) {
            return redirect('/')->with('error', 'Thông tin tuổi không hợp lệ.');
        }

        // Kiểm tra nếu tuổi nhỏ hơn 18 thì chuyển hướng về trang chủ với thông báo
        if ($age < 18) {
            return redirect('/')->with('error', 'Bạn chưa đủ 18 tuổi để truy cập trang này.');
        }

        // Nếu đủ tuổi, tiếp tục cho 

        return $next($request);
    }
}

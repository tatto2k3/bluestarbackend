<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có quyền là "Nhân viên" không
        if (Auth::check() && Auth::user()->position === 'Nhân viên') {
            return $next($request);
        }

        // Nếu không phải nhân viên, chuyển hướng về trang chính hoặc hiển thị thông báo lỗi
        return redirect('/')->withErrors('Bạn không có quyền truy cập vào trang này.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{


    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }
        // $user = Auth::guard('admin')->user();
        // if ($user->is_admin != 1) {
        //     return redirect('/user/userdashboard');
        // }

        return $next($request);
    }


}

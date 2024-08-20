<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;

use App\Models\Admin;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminController extends Controller
{
    public function Admindashboard(){
        $post=Post::count();
        $events=Events::count();
        $news=News::count();
        $admins=Admin::where('is_admin','0')->count();
        return view ('admin.dashboard',compact('post','events','news','admins'));
    }
    public function AdminLogout(Request $request){
        Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/admin/login');
     }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function view() {   
        $content = view('dashboard.view');
        return view('main',['content'=>$content]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function overview()
    {
        $user = Auth::user();

        $recentSubmittedClips = $user->clips()->with('user')->latest()->take(3)->get();

        return view('dashboard.overview', compact('user', 'recentSubmittedClips'));
    }
}
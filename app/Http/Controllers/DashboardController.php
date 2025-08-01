<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard overview.
     *
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $user = Auth::user();

        // You can fetch other data here, e.g.,
        // $recentClips = $user->clips()->latest()->take(5)->get();

        return view('dashboard.overview', compact('user'));
    }

    // public function myClips() {
    //     // Fetch and return user's clips
    //     return view('dashboard.my-clips');
    // }

    // public function settings() {
    //     // Display user settings
    //     return view('dashboard.settings');
    // }
}
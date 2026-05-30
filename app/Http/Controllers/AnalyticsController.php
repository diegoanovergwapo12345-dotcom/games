<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AnalyticsController extends Controller
{
    public function index()
{
    $allUsers      = User::all();
    $totalUsers    = $allUsers->count();
    $activeUsers   = $allUsers->where('status', 'active')->values();
    $inactiveUsers = $allUsers->where('status', 'inactive')->values();
    $activeCount   = $activeUsers->count();
    $inactiveCount = $inactiveUsers->count();
    $adminCount    = $allUsers->where('role', 'admin')->count();
    $userCount     = $allUsers->where('role', 'user')->count();

    // No more manual avatar mapping needed — the accessor handles it

    return view('analytics', compact(
        'totalUsers',
        'activeUsers',
        'inactiveUsers',
        'activeCount',
        'inactiveCount',
        'adminCount',
        'userCount'
    ));
}

}
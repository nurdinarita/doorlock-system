<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\AccessLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalMembers = Member::count();

        $todayAccess = AccessLog::whereDate('logged_at', $today)->count();

        $todayEntry = AccessLog::whereDate('logged_at', $today)
            ->where('action', 'entry')
            ->count();

        $todayExit = AccessLog::whereDate('logged_at', $today)
            ->where('action', 'exit')
            ->count();

        $latestLogs = AccessLog::with('member')
            ->orderBy('logged_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalMembers',
            'todayAccess',
            'todayEntry',
            'todayExit',
            'latestLogs'
        ));
    }
}

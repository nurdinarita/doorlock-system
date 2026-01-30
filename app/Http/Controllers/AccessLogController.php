<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\AccessLog;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = 10;

        if ($search) {
            $access_logs = AccessLog::whereHas('member', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('card_uid', 'like', "%{$search}%");
            })
            ->orderBy('logged_at', 'desc')
            ->paginate($perPage)
            ->appends(['search' => $search]);

        }else{
            $access_logs = AccessLog::with('member:id,card_uid,name,email,image')->orderBy('logged_at', 'desc')->paginate(10);
        }

        return view('access_logs.access_logs', compact('access_logs'));
    }
}

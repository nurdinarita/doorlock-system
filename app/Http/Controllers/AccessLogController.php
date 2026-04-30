<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\AccessLog;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportPdf(Request $request)
    {
        $query = AccessLog::with('member');

        // Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('logged_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('card_uid', 'like', "%$search%")
                ->orWhereHas('member', function($m) use ($search) {
                    $m->where('name', 'like', "%$search%");
                });
            });
        }

        $logs = $query->latest('logged_at')->get();

        // Load view khusus PDF
        $pdf = Pdf::loadView('access_logs.pdf', compact('logs'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Access_Logs_' . date('Y-m-d') . '.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Member;
use App\Models\AccessLog;

class RFIDController extends Controller
{
    public function readRFID(Request $request)
    {
        // $request->validate([
        //     'rfid_tag' => 'required|string',
        //     'mode' => 'required|string|in:read,add/update',
        //     'action' => 'required_if:mode,read|string|in:entry,exit',
        // ]);

        $rfidTag = $request->input('rfid_tag');
        $mode = strtolower($request->input('mode'));
        

        if ($mode === 'read') {
            $action = strtolower($request->input('action'));
            $member = Member::where('card_uid', $rfidTag)->first();

            if (!$member) {
                return response()->json([
                    'message' => 'Member not found'
                ], 404);
            }

            // Log access
            $accessLog = AccessLog::create([
                'member_id' => $member->id,
                'card_uid' => $rfidTag,
                'action' => $action,
                'logged_at' => now(),
            ]);

            if (!$accessLog) {
                return response()->json([
                    'message' => 'Failed to log access'
                ], 500);
            }

            return response()->json([
                'message' => 'Access granted',
                'member' => [
                    'name' => $member->name,
                    'image' => asset('storage/' . $member->image),
                ]
            ], 200);
        }

        if ($mode === 'add/update') {
            Cache::put('last_rfid', [
                'uid'  => $rfidTag,
                'time' => now()->timestamp,
            ], now()->addMinutes(2));

            return response()->json([
                'message' => 'RFID received',
                'uid'     => $rfidTag,
                'time'    => now()->timestamp,
            ]);
        }
    }

    public function getLastRFID()
    {
        $lastRfid = Cache::get('last_rfid');
        return response()->json($lastRfid ?: [
            'uid' => null,
            'time' => null,
        ]);
    }
}

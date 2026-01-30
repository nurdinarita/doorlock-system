<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Member;
use App\Models\AccessLog;

class RFIDController extends Controller
{
    public function readRFID(Request $request) {
        $rfidTag = $request->input('rfid_tag');
        $mode = $request->input('mode');

        if(strtolower($mode) === 'read')
        {
            $action = $request->input('action');
            $member = Member::where('card_uid', $rfidTag)->first();
            if($member && $action)
            {
                // Log access
                $AccessLog = AccessLog::create([
                    'member_id' => $member->id,
                    'card_uid' => $rfidTag,
                    'action' => $action,
                ]);

                if(!$AccessLog)
                {
                    return response()->json([
                        'message' => 'Failed to log access'
                    ], 500);
                }

                return response()->json([
                    'message' => 'Member found',
                    'member' => $member
                ], 200);
            }
            else
            {
                return response()->json([
                    'message' => 'Member not found'
                ], 404);
            }
        }

        if (strtolower($mode) === 'add/update') {

            Cache::put('last_rfid', [
                'uid'  => $request->rfid_tag,
                'time' => now()->timestamp,
            ], now()->addMinutes(2)); // lebih manusiawi

            return response()->json([
                'message' => 'RFID Recieved',
                'uid'     => $request->rfid_tag,
                'time'    => now()->timestamp,
            ]);
        }
    }
}

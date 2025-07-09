<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pillbox;
use App\Models\PillboxLog;
use Carbon\Carbon;

class DeviceController extends Controller
{
    // ✅ GET /api/device/pillbox/schedule/{device_uid}
   public function getSchedule($device_uid)
{
    $pillbox = Pillbox::where('device_uid', $device_uid)->first();

    if (!$pillbox) {
        return response()->json(['error' => 'Pillbox not found'], 404);
    }

    $today = Carbon::today();
    $dayName = $today->format('D'); // e.g., 'Mon'

    $schedules = $pillbox->schedules()
        ->with('medication')
        ->where('active', true)
        ->whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->get()
        ->filter(function ($schedule) use ($dayName) {
            return in_array($dayName, $schedule->days_of_week);
        })
        ->values();

    return response()->json([
        'device_uid' => $pillbox->device_uid,
        'schedules' => $schedules
    ]);
}

    // ✅ POST /api/device/pillbox/logs
    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            'device_uid' => 'required|string',
            'slot_number' => 'required|integer',
            'action' => 'required|in:opened,missed,skipped',
            'timestamp' => 'nullable|date',
        ]);

        $pillbox = Pillbox::where('device_uid', $request->device_uid)->first();

        if (!$pillbox) {
            return response()->json(['error' => 'Pillbox not found'], 404);
        }

        $log = PillboxLog::create([
            'pillbox_id' => $pillbox->id,
            'slot_number' => $request->slot_number,
            'action' => $request->action,
            'timestamp' => $request->timestamp ?? now(),
            'synced_by_device' => true
        ]);

        return response()->json(['message' => 'Log saved', 'log' => $log]);
    }
}

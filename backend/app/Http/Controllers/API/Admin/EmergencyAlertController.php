<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;
use Carbon\Carbon;

class EmergencyAlertController extends Controller
{
    public function index()
    {
        $alerts = EmergencyAlert::with(['driver', 'bus', 'trip'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($alerts);
    }

    public function acknowledge($id)
    {
        $alert = EmergencyAlert::findOrFail($id);
        $alert->update([
            'status' => 'acknowledged',
            'acknowledged_at' => Carbon::now(),
        ]);

        return response()->json($alert);
    }
}

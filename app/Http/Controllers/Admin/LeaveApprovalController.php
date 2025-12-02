<?php

namespace App\Http\Controllers\Admin;

use App\Models\PendingLeave;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LeaveType;


class LeaveApprovalController extends Controller
{
    // FINAL INDEX FUNCTION WITH SEARCH
    public function index(Request $request)
    {
        $search = $request->input('search');

        $leaveApplications = LeaveApplication::with(['user', 'leaveType'])
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->get();
            
        return view('Admin.Leave.index', compact('leaveApplications'));
    }

    public function approve($id)
{
    $application = LeaveApplication::findOrFail($id);

    // Use EXACT days stored in DB (0.5 OR 1 OR multi-day)
    $days = $application->days;  // ← THIS FIXES HALF DAY ISSUE
    
    // Update leave status
    $application->status = 'approved';
    $application->approval_date = now();
    $application->save();

    // Update pending leaves table
    $pending = PendingLeave::where('user_id', $application->user_id)
        ->where('leave_type_id', $application->leave_type_id)
        ->where('year', now()->year)
        ->first();

    if ($pending) {
        $pending->used += $days;
        $pending->remaining = max(0, $pending->total - $pending->used);
        $pending->save();
    }

    return back()->with('success', 'Leave approved and balance updated!');
}
public function reject($id)
{
    $application = LeaveApplication::findOrFail($id);

    $application->status = 'rejected';
    $application->approval_date = now();
    $application->save();

    return back()->with('success', 'Leave rejected successfully!');
}

public function userLeaveTotals($userId)
{
    $user = User::findOrFail($userId);
    $leaveTypes = LeaveType::all();

    $pending = PendingLeave::where('user_id', $userId)
        ->get()
        ->keyBy('leave_type_id');

    if ($pending->isNotEmpty()) {
        $data = $leaveTypes->map(function ($type) use ($pending) {
            $p = $pending->get($type->id);
            return [
                'id' => $type->id,
                'name' => $type->name,
                'total' => $p ? floatval($p->total) : 0,
                'used' => $p ? floatval($p->used) : 0,
                'remaining' => $p ? floatval($p->remaining) : 0,
            ];
        })->values();
    } else {
        $totals = LeaveApplication::where('user_id', $userId)
            ->selectRaw('leave_type_id, SUM(days) as used')
            ->groupBy('leave_type_id')
            ->get()
            ->keyBy('leave_type_id');

        $data = $leaveTypes->map(function ($type) use ($totals) {
            $row = $totals->get($type->id);
            return [
                'id' => $type->id,
                'name' => $type->name,
                'total' => null, // unknown without PendingLeave
                'used' => $row ? floatval($row->used) : 0,
                'remaining' => null,
            ];
        })->values();
    }

    // Calculate final total row
    $totalsRow = [
        'name' => 'Total',
        'total' => $data->sum('total'),
        'used' => $data->sum('used'),
        'remaining' => $data->sum('remaining'),
    ];

    return response()->json([
        'user' => ['id' => $user->id, 'name' => $user->name],
        'totals' => $data,
        'totalsRow' => $totalsRow,
    ]);
}


}
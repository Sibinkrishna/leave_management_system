<?php

namespace App\Http\Controllers\Admin;

use App\Models\PendingLeave;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveType;

class LeaveApprovalController extends Controller
{
    // INDEX WITH SEARCH
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

        return view('Admin.Leave.index', compact('leaveApplications', 'search'));
    }

    // UPDATE STATUS VIA AJAX (optional, unified)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $application = LeaveApplication::findOrFail($id);
        $application->status = $request->status;
        $application->approval_date = now();
        $application->save();

        if ($request->status === 'approved') {
            $pending = PendingLeave::where('user_id', $application->user_id)
                ->where('leave_type_id', $application->leave_type_id)
                ->where('year', now()->year)
                ->first();

            if ($pending) {
                $pending->used += $application->days;
                $pending->remaining = max(0, $pending->total - $pending->used);
                $pending->save();
            }
        }

        return response()->json([
            'success' => true,
            'status' => $application->status,
            'leave_id' => $application->id,
        ]);
    }

    // SEPARATE APPROVE METHOD
    public function approve($id)
    {
        $application = LeaveApplication::findOrFail($id);
        $application->status = 'approved';
        $application->approval_date = now();
        $application->save();

        // Update pending leave
        $pending = PendingLeave::where('user_id', $application->user_id)
            ->where('leave_type_id', $application->leave_type_id)
            ->where('year', now()->year)
            ->first();

        if ($pending) {
            $pending->used += $application->days;
            $pending->remaining = max(0, $pending->total - $pending->used);
            $pending->save();
        }

        return response()->json(['success' => true, 'status' => 'approved']);
    }

    // SEPARATE REJECT METHOD
    public function reject($id)
    {
        $application = LeaveApplication::findOrFail($id);
        $application->status = 'rejected';
        $application->approval_date = now();
        $application->save();

        return response()->json(['success' => true, 'status' => 'rejected']);
    }

    // FETCH USER LEAVE TOTALS
    public function userLeaveTotals($userId)
    {
        $user = User::findOrFail($userId);
        $leaveTypes = LeaveType::all();
        $pending = PendingLeave::where('user_id', $userId)->get()->keyBy('leave_type_id');

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
                    'total' => null,
                    'used' => $row ? floatval($row->used) : 0,
                    'remaining' => null,
                ];
            })->values();
        }

        $totalsRow = [
            'name' => 'Total',
            'total' => $data->sum('total') ?? 0,
            'used' => $data->sum('used') ?? 0,
            'remaining' => $data->sum('remaining') ?? 0,
        ];

        return response()->json([
            'user' => ['id' => $user->id, 'name' => $user->name],
            'totals' => $data,
            'totalsRow' => $totalsRow,
        ]);
    }
}

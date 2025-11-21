@extends('Admin.Layouts.app')

@section('content')

@php
// Format like: 15 -> 15 | 2.5 -> 2.5
function formatDays($v) {
    return ($v == intval($v)) ? intval($v) : rtrim(rtrim($v, '0'), '.');
}
@endphp

<style>
/* ——— SAME CSS ——— */
.card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden; }
.table th, .table td { vertical-align: middle; }
.card-header { padding: 0.9rem 1rem; }
.card-header h5 { font-size: 1.1rem; margin-bottom: 0; }
.card-header span { font-size: 0.9rem; opacity: 0.9; }
.card-body { padding: 1rem; padding-top: 1.2rem; }
.table thead th { background-color: #f8f9fa; font-weight: 600; }
.table tfoot th { background-color: #f1f3f5; font-weight: 600; }
</style>

<!-- PAGE TITLE -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0"></h4>
            <ol class="breadcrumb mb-0 ms-auto">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Leaves</a></li>
                <li class="breadcrumb-item active">Pending</li>
            </ol>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card mt-3">

            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3">
                <h5 class="mb-0 fs-6 fs-md-5">Pending Leaves</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Leave Type</th>
                                <th>Total Days</th>
                                <th>Used Days</th>
                                <th>Remaining Days</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pendingLeaves as $leave)
                                <tr>
                                    <td>{{ $leave->leaveType->name }}</td>
                                    <td>{{ formatDays($leave->total) }}</td>
                                    <td>{{ formatDays($leave->used) }}</td>
                                    <td>{{ formatDays($leave->remaining) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted py-3">No pending leaves found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="table-light">
                            <tr>
                                <th>Total</th>
                                <th>{{ formatDays($totalAll['total_leaves']) }}</th>
                                <th>{{ formatDays($totalAll['used_leaves']) }}</th>
                                <th>{{ formatDays($totalAll['remaining_leaves']) }}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

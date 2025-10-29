@extends('Admin.Layouts.app')

@section('content')
<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">Pending Leaves</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Leaves</a></li>
                <li class="breadcrumb-item active">Pending</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Pending Leave Requests</h5>
                <span>({{ Auth::user()->name }})</span>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Leave Type</th>
                            <th>Total Days</th>
                            <th>Used Days</th>
                            <th>Remaining Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employeeLeaves as $leave)
                            <tr>
                                <td>{{ $leave->leaveType->leave_name }}</td>
                                <td>{{ $leave->total_days }}</td>
                                <td>{{ $leave->used_days }}</td>
                                <td>{{ $leave->remaining_days }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No leave records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

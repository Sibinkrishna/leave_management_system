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

                            <tr>
                                <th>Leave Type</th>
                                <th>Total</th>
                                <th>Used</th>
                                <th>Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingLeaves as $leave)
                                 <tr>
                                    <td>{{ $leave->leaveType->name }}</td>
                                    <td>{{ $leave->total }}</td>
                                    <td>{{ $leave->used }}</td>
                                    <td>{{ $leave->remaining }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No pending leaves found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>Total</th>
                                <th>{{ $totalAll['total_leaves'] }}</th>
                                <th>{{ $totalAll['used_leaves'] }}</th>
                                <th>{{ $totalAll['remaining_leaves'] }}</th>
                            </tr>
                        </tfoot>
                    </table><!-- end table -->
                </div><!-- end table-responsive -->
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>
@endsection

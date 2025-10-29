@extends('Admin.Layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Leave Applications</h5>
           <a href="{{ route('employee.leaveapplications.create') }}" class="btn btn-sm btn-light">+ Apply Leave</a>

        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Days</th>
                        <!-- <th>Subject</th> -->
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $key => $leave)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $leave->leaveType->name ?? '-' }}</td>
                            <td>{{ $leave->start_date }}</td>
                            <td>{{ $leave->end_date }}</td>
                            <td>{{ $leave->days }}</td>                
                            <!-- <td>{{ $leave->subject ?? '-'}}</td> -->
                            <td>
                                @if($leave->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($leave->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">No leave applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

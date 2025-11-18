@extends('Admin.Layouts.app')

@section('content')
<!-- ✅ Page Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0"></h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Leaves</a></li>
                <li class="breadcrumb-item active">Apply</li>
            </ol>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="card shadow-sm rounded-3">
        <!-- ✅ Compact Header (Auto adjusts for mobile) -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3">
            <h5 class="mb-0 fs-6 fs-md-5">Leave Applications</h5>
            <a href="{{ route('employee.leaveapplications.create') }}"
               class="btn btn-sm btn-primary">+ Apply Leave</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>Id</th>
                        <th>Leave Type</th>
                        <th>Days</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $key => $leave)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $leave->leaveType->name ?? '-' }}</td>
                            <td>{{ $leave->days }}</td>
                            <td>
                                @if($leave->status == 'pending')
                                    <span class="badge bg-warning text-dark px-2 py-1 small">Pending</span>
                                @elseif($leave->status == 'approved')
                                    <span class="badge bg-success px-2 py-1 small">Approved</span>
                                @else
                                    <span class="badge bg-danger px-2 py-1 small">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">No leave applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('Admin.Layouts.app')

@section('content')
<!-- ✅ Page Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0">Leave application</h4>
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
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Leave Applications</h5>
            <a href="{{ route('employee.leaveapplications.create') }}" class="btn btn-sm btn-primary">+ Apply Leave</a>
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
                        {{-- <th>Start Date</th> --}}
                        {{-- <th>End Date</th> --}}
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
                            {{-- <td>{{ $leave->start_date }}</td> --}}
                            {{-- <td>{{ $leave->end_date }}</td> --}}
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

{{-- ✅ Responsive Font Sizes --}}
<style>
/* ✅ Default Desktop View */
body {
    font-size: 16px;
}

.table th, .table td {
    font-size: 15px;
}

.card-header h5 {
    font-size: 18px;
}

/* ✅ Tablet View */
@media (max-width: 1024px) {
    body {
        font-size: 15px;
    }
    .table th, .table td {
        font-size: 14px;
    }
    .card-header h5 {
        font-size: 17px;
    }
    .btn {
        font-size: 14px;
        padding: 6px 10px;
    }
}

/* ✅ Mobile View */
@media (max-width: 768px) {
    body {
        font-size: 14px;
    }
    .table th, .table td {
        font-size: 13px;
        padding: 6px 8px;
    }
    .card-header h5 {
        font-size: 16px;
        text-align: center;
    }
    .btn {
        font-size: 13px;
        padding: 5px 8px;
    }
    .badge {
        font-size: 12px;
        padding: 4px 8px;
    }
}

/* ✅ Small Mobile View */
@media (max-width: 430px) {
    body {
        font-size: 13px;
    }
    .table th, .table td {
        font-size: 12px;
        padding: 4px 6px;
    }
    .card-header h5 {
        font-size: 15px;
    }
    .btn {
        font-size: 12px;
        padding: 4px 6px;
    }
    .badge {
        font-size: 11px;
        padding: 3px 6px;
    }
}
</style>
@endsection

@extends('Admin.Layouts.app')

@section('content')
<!-- ✅ Page Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0"></h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                <li class="breadcrumb-item active">List</li>
                
            </ol>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="card shadow-sm rounded-3">
        <!-- ✅ Header -->
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3">

<div class="d-flex align-items-center flex-wrap gap-1">
                 <h5 class="mb-0 fs-6 fs-md-5">Attendance Records</h5> 
                {{-- <span class="small">({{ Auth::user()->name }})</span> --}}
            </div>

            <!-- ✅ Filter Form -->
            <form method="GET" action="{{ route('employee.attendance.records') }}" class="d-flex flex-wrap align-items-center gap-2">
                <input 
                    type="date" 
                    name="date" 
                    class="form-control form-control-sm w-auto"
                    value="{{ request('date') }}"
                >
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-search"></i> Filter
                </button>
            </form>
        </div>

        <!-- ✅ Table Section -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record['date'])->format('d-m-Y') }}</td>
                                <td>{{ $record['check_in'] }}</td>
                                <td>{{ $record['check_out'] }}</td>
                                <td>
                                    @if(is_numeric($record['duration']))
                                        {{ number_format($record['duration'], 2) }} hr
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    @if($record['status'] === 'Present')
                                        <span class="badge bg-success">Present</span>
                                    @elseif($record['status'] === 'Weekend')
                                        <span class="badge bg-secondary">Weekend</span>
                                    @elseif($record['status'] === 'Holiday')
                                        <span class="badge bg-info text-dark">Holiday</span>
                                    @else
                                        <span class="badge bg-danger">Absent</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-3">No records found for this month.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Responsive Font Sizes --}}
<style>


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
    .card-header span {
        font-size: 13px;
    }
    .btn {
        font-size: 13px;
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
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        text-align: left;
    }
    .card-header h5 {
        font-size: 16px;
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

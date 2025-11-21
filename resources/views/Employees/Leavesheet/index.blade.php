@extends('Admin.Layouts.app')

@section('content')

<!-- ✅ Page Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0"></h4>
            <ol class="breadcrumb mb-0 ms-auto"> <!-- ✅ Always right side -->
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Leaves</a></li>
                <li class="breadcrumb-item active">Sheet</li>
            </ol>
        </div>
    </div>
</div>



<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-sm border-0 mt-3 w-100">
            
            <!-- ✅ Card Header -->
         <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3">
                 <h5 class="mb-0 fs-6 fs-md-5">Leave Summary</h5> 
                {{-- <span class="text-light small">({{ Auth::user()->name }})</span> --}}
            </div>

            <!-- ✅ Table Section -->
            <div class="card-body pt-3 pb-2 px-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle mb-0 w-100">
                        <thead class="table-light">
                            <tr>
                                <th>Leave Type</th>
                                <th>Leave From</th>
                                <th>Leave To</th>
                                <th>Total Days</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaveApplications as $application)
                                <tr>
                                    <td>{{ $application->leaveType->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($application->start_date)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($application->end_date)->format('d-m-Y') }}</td>
                                    <td>{{ $application->days = floatval($application->days); }}</td> 
                                    <td>
                                          @if($application->status == 'pending')
                                          <span class="badge bg-warning text-dark px-2 py-1 small fw-normal">Pending</span>
                                          @elseif($application->status == 'approved')
                                          <span class="badge bg-success px-2 py-1 small fw-normal">Approved</span>
                                          @else
                                          <span class="badge bg-danger px-2 py-1 small fw-normal">Rejected</span>
                                          @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted py-3">No leave records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>

<!-- ✅ Full Responsive Styling -->
<style>
/* ====== BASE STYLES (Desktop ≥1025px) ====== */
.page-title-box {
    margin-bottom: 10px;
}
.page-title {
    font-size: 1.4rem;
    font-weight: 600;
}
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th, .table td {
    vertical-align: middle;
    white-space: nowrap;
    font-size: 13px;
    padding: 10px;
}
.card-header h5 {
    font-size: 1.15rem;
}
.card-header span {
    font-size: 0.95rem;
}
.badge {
    font-size: 0.9rem;
    padding: 6px 10px;
    border-radius: 8px;
}
.card {
    width: 100%;
    border-radius: 10px;
}
.table-responsive {
    width: 100%;
    overflow-x: auto;
}

/* ====== TABLET VIEW (768px – 1024px) ====== */
@media (max-width: 1024px) {
    .page-title {
        font-size: 1.2rem;
    }
    .card-header h5 {
        font-size: 1rem;
    }
    .card-header span {
        font-size: 0.9rem;
    }
    .table th, .table td {
        font-size: 12px;
        padding: 8px;
    }
    .badge {
        font-size: 0.8rem;
        padding: 5px 8px;
    }
}

/* ====== MOBILE VIEW (<768px) ====== */
@media (max-width: 767px) {
    .page-title-box {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        gap: 6px;
    }
    .page-title {
        font-size: 1rem;
    }
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    .card-header h5 {
        font-size: 0.95rem;
    }
    .card-header span {
        font-size: 0.85rem;
    }
    .table th, .table td {
        font-size: 10px;
        padding: 7px 6px;
        white-space: normal;
    }
    .badge {
        font-size: 0.8rem;
        padding: 4px 7px;
    }
}

/* ====== SMALL MOBILE VIEW (<480px) ====== */
@media (max-width: 480px) {
    .page-title {
        font-size: 0.95rem;
    }
    .card-header h5 {
        font-size: 0.9rem;
    }
    .card-header span {
        font-size: 0.8rem;
    }
    .table th, .table td {
        font-size: 12px;
        padding: 5px 4px;
    }
    .badge {
        font-size: 0.75rem;
        padding: 3px 6px;
    }
}
</style>
@endsection

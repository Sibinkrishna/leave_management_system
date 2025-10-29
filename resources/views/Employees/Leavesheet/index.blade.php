@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Leave Sheet</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Leaves</a></li>
                    <li class="breadcrumb-item active">Sheet</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <h4 class="card-title">Employee Leave Summary</h4>
                        <!-- <h6 class="text-muted mb-0">Name: {{ Auth::user()->name }}</h6> -->
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
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
                    <td>{{ \Carbon\Carbon::parse($application->start_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($application->end_date)->format('d M Y') }}</td>
                    <td>{{ $application->days }}</td>
                    <td>
                        @if($application->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($application->status == 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No leave records found.</td>
                </tr>
            @endforelse
                        </tbody>
                    </table><!-- end table -->
                </div><!-- end table-responsive -->
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>
@endsection

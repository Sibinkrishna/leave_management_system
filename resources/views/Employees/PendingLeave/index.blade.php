@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Pending Leaves</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Leaves</a></li>
                    <li class="breadcrumb-item active">Pending</li>
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
                        <h4 class="card-title">My Pending Leave Requests</h4>
                        <!-- <h6 class="text-muted mb-0">Name: {{ Auth::user()->name }}</h6> -->
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Casual Leave</th>
                                <th>Medical leave</th>
                                <th>WFH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingLeaves as $leave)
                                <!-- <tr>
                                    <td>{{ $leave->type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d M, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d M, Y') }}</td>
                                    <td>{{ $leave->reason ?? '—' }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $leave->status }}</span>
                                    </td>
                                </tr> -->
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No pending leaves found.</td>
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

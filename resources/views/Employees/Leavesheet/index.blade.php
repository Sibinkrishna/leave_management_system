@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">Leave Sheet</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Leaves</a></li>
                <li class="breadcrumb-item active">Sheet</li>
            </ol>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">My Employee Leave Summary</h5>
                <span class="fw-bold">(DIPPU)</span>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Casual Leave</th>
                            <th>Medical Leave</th>
                            <th>WFH</th>
                            {{-- <th>Half Day</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach (['Casual', 'Medical', 'WFH', ] as $type)
                                <td>
                                    @if (!empty($leavesGrouped[$type]))
                                        @foreach ($leavesGrouped[$type] as $dateRange)
                                            <div>{{ $dateRange }}</div>
                                        @endforeach
                                    @else
                                        <small class="text-muted">No leave records found.</small>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

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
                                <th>Casual Leave</th>
                                <th>Medical Leave</th>
                                <th>WFH</th>
                                <th>Half Day</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $maxRows = max(
                                    count($leavesGrouped['Casual'] ?? []),
                                    count($leavesGrouped['Medical'] ?? []),
                                    count($leavesGrouped['WFH'] ?? []),
                                    count($leavesGrouped['Half Day'] ?? [])
                                );
                            @endphp

                            @if($maxRows > 0)
                                @for($i = 0; $i < $maxRows; $i++)
                                    <tr>
                                        <td>{{ $leavesGrouped['Casual'][$i] ?? '' }}</td>
                                        <td>{{ $leavesGrouped['Medical'][$i] ?? '' }}</td>
                                        <td>{{ $leavesGrouped['WFH'][$i] ?? '' }}</td>
                                        <td>{{ $leavesGrouped['Half Day'][$i] ?? '' }}</td>
                                    </tr>
                                @endfor
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No leave records found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table><!-- end table -->
                </div><!-- end table-responsive -->
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>
@endsection

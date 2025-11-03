@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">Attendance Sheet</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                <li class="breadcrumb-item active">Records</li>
            </ol>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- ✅ Header with Month-Year Filter -->
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0 fw-bold">My Attendance Records</h5>
                    <span>({{ Auth::user()->name }})</span>
                </div>
                   <!-- Filter Form -->
                <form method="GET" action="{{ route('employee.attendance.records') }}" class="d-flex align-items-center gap-2">
                    <select name="month" class="form-select form-select-sm" style="width:auto;">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>

                    <select name="year" class="form-select form-select-sm" style="width:auto;">
                        @for ($y = now()->year; $y >= now()->year - 3; $y--)
                            <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>

                    <button type="submit" class="btn btn-sm btn-light text-dark border">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </form>
            </div>
             <!-- ✅ Attendance Table -->
            <div class="card-body">
                <table class="table table-bordered text-center align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Duration (min)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td>{{ $record['date'] }}</td>
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
                                   @else
                                      <span class="badge bg-danger">Absent</span>
                                       @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
select.form-select-sm {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 4px 8px;
}
</style>
@endsection
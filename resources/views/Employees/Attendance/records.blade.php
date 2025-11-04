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
            <!-- ✅ Header -->
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0 fw-bold">My Attendance Records</h5>
                    <span>({{ Auth::user()->name }})</span>
                </div>
                
                <!-- ✅ Filter Form -->
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

            <!-- ✅ Table -->
            <div class="card-body">
                <table class="table table-bordered text-center align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Duration (hrs)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
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
                                        <span class="status-badge present">Present</span>
                                    @elseif($record['status'] === 'Weekend')
                                        <span class="status-badge weekend">Weekend</span>
                                    @elseif($record['status'] === 'Holiday')
                                        <span class="status-badge holiday">Holiday</span>
                                    @else
                                        <span class="status-badge absent">Absent</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">No records found for this month.</td>
                            </tr>
                        @endforelse
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

/* ✅ Soft and clean status badges */
.status-badge {
    display: inline-block;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 10px;
    /* bytton-size:15px; */
    letter-spacing: 0.3px;
    transition: all 0.2s ease-in-out;
}

/* ✅ Light pastel colors */
.status-badge.present {
    background-color: #5bff94ff; /* soft green */
    color: #28563aff;
}

.status-badge.absent {
    background-color: #ff9a9aff; /* soft red */
    color: #161515ff;
}

.status-badge.weekend {
    background-color: #f4f5f7ff; /* soft gray */
    color: #374151;
}

.status-badge.holiday {
    background-color: #a2e8eeff; /* soft cyan */
    color: #0e7490;
}

/* ✅ Optional hover effect */
.status-badge:hover {
    transform: scale(1.05);
    opacity: 0.9;
}
</style>
@endsection

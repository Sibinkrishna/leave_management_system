@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-between align-items-center">
            <h4 class="page-title">WFH Records</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Work From Home</a></li>
                    <li class="breadcrumb-item active">Summary</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center mb-2">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="mb-0 fw-bold">WFH Recors List</h6>
                    {{-- <span>Admin Panel</span> --}}
                </div>

                <!-- Month & Year Filter Form -->
                <!-- Month, Year, and Date Filter Form -->
<!-- Day, Month, Year Filter Form -->
<form method="GET" action="{{ route('admin.wfh.index') }}" class="d-flex align-items-center gap-2">

    <!-- Day -->
    <select name="day" class="form-select form-select-sm" style="width:auto;">
        <option value="">Day</option>
        @for ($d = 1; $d <= 31; $d++)
            <option value="{{ $d }}" {{ request('day') == $d ? 'selected' : '' }}>{{ $d }}</option>
        @endfor
    </select>

    <!-- Month -->
    <select name="month" class="form-select form-select-sm" style="width:auto;">
        <option value="">Month</option>
        @for ($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>
                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
            </option>
        @endfor
    </select>

    <!-- Year -->
    <select name="year" class="form-select form-select-sm" style="width:auto;">
        <option value="">Year</option>
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

            <!-- Table -->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                               <th>User_Id</th>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Work Duration</th>
                                <th>Task Summary</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($entries as $entry)
                                <tr>
                                    <td>{{ $entry->user->id ?? 'N/A' }}</td> <!-- show user ID -->
                                    <td>{{ $entry->user->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($entry->entry_date)->format('d M Y') }}</td>
                                    <td>{{ $entry->work_time }}</td>
                                    <td>{{ $entry->task_summary }}</td>
                                    <td>
                                        @if(strtolower($entry->notes) == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif(strtolower($entry->notes) == 'working')
                                            <span class="badge bg-warning text-dark">Working</span>
                                        @elseif(strtolower($entry->notes) == 'doing')
                                            <span class="badge bg-info text-dark">Doing</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Work From Home records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table><!-- end table -->
                </div><!-- end table-responsive -->
            </div><!-- end card-body -->
        </div><!-- end card -->
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

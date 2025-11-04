@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">Holiday List</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Holiday</a></li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Company Holiday Summary</h5>
                <span>({{ Auth::user()->name }})</span>
            </div>

            <div class="card-body">
                <table class="table table-bordered text-center align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Holiday Name</th>
                            <th>Date</th>
                            <th>Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($holidays as $holiday)
                            <tr>
                                <td>{{ $holiday->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($holiday->date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($holiday->date)->format('l') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No holidays found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>
@endsection

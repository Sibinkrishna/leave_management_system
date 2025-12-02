@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Edit Holiday</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active">Edit Holiday</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Update Holiday</h4>
                    </div>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if(session('success')) 
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('admin.holiday.update', $holiday->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Holiday Name -->
                        <div class="col-md-4 mb-3">
                            <label for="holidayName" class="form-label">Holiday Name</label>
                            <input type="text" class="form-control" id="holidayName" name="name" 
                                   value="{{ old('name', $holiday->name) }}" placeholder="Enter holiday name" required>
                        </div>

                        <!-- Date -->
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   value="{{ old('date', \Carbon\Carbon::parse($holiday->date)->format('Y-m-d')) }}"
 required>
                        </div>

                        <!-- Day -->
                        <div class="col-md-4 mb-3">
                            <label for="day" class="form-label">Day</label>
                            <input type="text" class="form-control" id="day" name="day" 
                                   value="{{ \Carbon\Carbon::parse($holiday->date)->format('l') }}" readonly>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.holiday.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

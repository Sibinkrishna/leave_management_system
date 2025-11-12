@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Edit Leave Type</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active">Edit Leave Type</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Leave Type Form</h4>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif  

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body pt-0">
                <form action="{{ route('admin.leavetype.update', $leavetype->id) }}" method="POST">
                    @csrf
                    <div class="row">

                        <!-- Name -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" 
                                       value="{{ old('name', $leavetype->name) }}" placeholder="Enter name">
                            </div>
                        </div>

                        <!-- Total Days Per Year -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="total_days_per_year" class="form-label">Total Days Per Year</label>
                                <input type="number" class="form-control" name="total_days_per_year" id="total_days_per_year" 
                                       value="{{ old('total_days_per_year', $leavetype->total_days_per_year) }}" placeholder="Enter total days per year">
                            </div>
                        </div>

                        <!-- Carry Forward -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="carry_forward" class="form-label">Carry Forward</label>
                                <select class="form-control" name="carry_forward" id="carry_forward">
                                    <option value="" disabled>--select--</option>
                                    <option value="1" {{ old('carry_forward', $leavetype->carry_forward) == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('carry_forward', $leavetype->carry_forward) == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" name="description" id="description" 
                                       value="{{ old('description', $leavetype->description) }}" placeholder="Enter description">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="" disabled>--select--</option>
                                    <option value="active" {{ old('status', $leavetype->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $leavetype->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.department.index') }}" class="btn btn-danger">Cancel</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

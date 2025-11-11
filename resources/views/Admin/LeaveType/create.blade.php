@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Add Leave Type</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active">Elements</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Full-width container --}}
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Leave Type Form</h4>
            </div>

            {{-- Display Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-3 mx-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error) 
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif  

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('admin.leavetype.store') }}" method="POST">
                    @csrf

                    {{-- Responsive grid --}}
                    <div class="row g-3">

                        <div class="col-12 col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name') }}" 
                                   placeholder="Enter leave type name" 
                                   required>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="total_days_per_year" class="form-label">Total Days / Year</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="total_days_per_year" 
                                   id="total_days_per_year"
                                   value="{{ old('total_days_per_year') }}" 
                                   min="0" 
                                   placeholder="Enter total days" 
                                   required>
                        </div>

                        <div class="col-12 col-md-4 d-flex align-items-center mt-2">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       name="carry_forward" 
                                       id="carry_forward" 
                                       value="1"
                                       {{ old('carry_forward') ? 'checked' : '' }}>
                                <label class="form-check-label" for="carry_forward">Carry Forward</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" 
                                      name="description" 
                                      id="description" 
                                      rows="3"
                                      placeholder="Enter description">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="" disabled selected>-- Select --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                       <a href="{{ route('admin.employee.index') }}" class="btn btn-danger">Cancel</a>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

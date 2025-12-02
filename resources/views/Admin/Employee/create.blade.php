@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Add Employee</h4>
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

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Employee Form</h4>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body pt-0">
                <form action="{{ route('admin.employee.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="company_id" value="1">
                    <input type="hidden" name="role" value="employee">

                    <div class="row gy-2 gy-md-3">

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}" placeholder="Enter name">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone')}}" placeholder="Enter phone number">
                            @error('phone')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" placeholder="Enter email">
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                       <div class="col-lg-4 col-md-6 col-12">
    <label class="form-label">Password</label>
    <div class="input-group">
        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password">
        <span class="input-group-text" onclick="togglePassword('password', this)" style="cursor:pointer;">
            <i class="bi bi-eye"></i>
        </span>
    </div>
    @error('password')
        <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>

                   <div class="col-lg-4 col-md-6 col-12">
    <label class="form-label">Confirm Password</label>
    <div class="input-group">
        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm password">
        <span class="input-group-text" onclick="togglePassword('password_confirmation', this)" style="cursor:pointer;">
            <i class="bi bi-eye"></i>
        </span>
    </div>
</div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ old('designation')}}" placeholder="Enter designation">
                            @error('designation')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Join Date</label>
                            <input type="date" class="form-control @error('join_date') is-invalid @enderror" name="join_date" value="{{ old('join_date')}}">
                            @error('join_date')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Select --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Department</label>
                            <select class="form-control @error('department_id') is-invalid @enderror" name="department_id">
                                <option value="" disabled {{ old('department_id') ? '' : 'selected' }}>-- Select Department --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Avatar</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
                            @error('avatar')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" onclick="window.history.back()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    const icon = el.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>


@endsection

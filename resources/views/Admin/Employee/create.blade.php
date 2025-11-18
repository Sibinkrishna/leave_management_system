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
                <form action="{{ route('admin.employee.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- ✅ Responsive Form Section -->
                    <!-- gy-2 = small vertical gap on mobile -->
                    <!-- gy-md-3 = normal gap on tablet/desktop -->
                    <div class="row gy-2 gy-md-3">
                        <input type="hidden" name="company_id" value="1">
                        <input type="hidden" name="role" value="employee">

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name')}}" placeholder="Enter name">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone" value="{{ old('phone')}}" placeholder="Enter phone number">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email')}}" placeholder="Enter email">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address')}}" placeholder="Enter address">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" value="{{ old('designation')}}" placeholder="Enter designation">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Join Date</label>
                            <input type="date" class="form-control" name="join_date" value="{{ old('join_date')}}">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="" disabled selected>-- Select --</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Department</label>
                            <select class="form-control" name="department_id" required>
                                <option value="" disabled selected>-- Select Department --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Avatar</label>
                            <input type="file" class="form-control" name="avatar" value="{{ old('avatar')}}">
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
@endsection

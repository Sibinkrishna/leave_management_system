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

                    <div class="row">
                        <input type="hidden" name="company_id" value="1">
                        <input type="hidden" name="role" value="employee">

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputname" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name')}}"  id="exampleInputname" placeholder="Enter name">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputphone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone"  value="{{ old('phone')}}" id="exampleInputphone" placeholder="Enter phone number">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email"  value="{{ old('email')}}"id="exampleInputEmail1" placeholder="Enter email">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Enter password">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword2" placeholder="Confirm password">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputaddress" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address')}}" id="exampleInputaddress" placeholder="Enter address">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputdesignation" class="form-label">Designation</label>
                                <input type="text" class="form-control" name="designation"  value="{{ old('designation')}}"id="exampleInputdesignation" placeholder="Enter designation">
                            </div>
                        </div>

                       <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputjoin date" class="form-label">Join date</label>
                                <input type="date" class="form-control" name="join date" value="{{ old('join date')}}" id="exampleInputjoin date" placeholder="Join date">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputstatus" class="form-label">Status</label>
                            <select class="form-control" name="status" value="{{ old('status')}}" id="">
                                <option value=""selected disabled>--select--</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-4">
    <div class="mb-3">
        <label for="department_id" class="form-label">Department</label>
        <select class="form-control" name="department_id" id="department_id" required>
            <option value="" disabled>-- Select Department --</option>
            @forelse($departments as $department)
                <option value="{{ $department->id }}" 
                    {{ $department->department_id == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @empty
                <option value="" disabled>No departments found</option>
            @endforelse
        </select>
    </div>
</div>


                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleInputavatar" class="form-label">Avatar</label>
                                <input type="file" class="form-control" name="avatar" value="{{ old('avatar')}}" id="exampleInputavatar" placeholder="Avatar">
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

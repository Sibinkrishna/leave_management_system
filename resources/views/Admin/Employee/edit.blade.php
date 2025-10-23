@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Edit Employee</h4>
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

            <!-- Validation Errors -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif  

            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card-body pt-0">
                <form action="{{ route('admin.employee.update', $employee->id ) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Hidden fields -->
                        <input type="hidden" name="company_id" value="1">
                        <input type="hidden" name="role" value="employee">

                        <!-- Name -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $employee->name) }}" id="nameInput" placeholder="Enter name">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="phoneInput" class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone', $employee->phone) }}" id="phoneInput" placeholder="Enter phone number">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="emailInput" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $employee->email) }}" id="emailInput" placeholder="Enter email">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="addressInput" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address', $employee->address) }}" id="addressInput" placeholder="Enter address">
                            </div>
                        </div>

                        <!-- Designation -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="designationInput" class="form-label">Designation</label>
                                <input type="text" class="form-control" name="designation" value="{{ old('designation', $employee->designation) }}" id="designationInput" placeholder="Enter designation">
                            </div>
                        </div>

                        <!-- Join Date -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="joinDateInput" class="form-label">Join Date</label>
                                <input type="date" class="form-control" name="join_date" value="{{ old('join_date', $employee->join_date) }}" id="joinDateInput" placeholder="Join Date">
                            </div>
                        </div>

                        <!-- Department -->
                       <div class="col-4">
    <div class="mb-3">
        <label for="departmentSelect" class="form-label">Department</label>
        <select class="form-control" name="department_id" id="departmentSelect">
            <option value="" selected disabled>--select--</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" @if($employee->department_id == $department->id) selected @endif>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>


                        <!-- Status -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="statusSelect" class="form-label">Status</label>
                                <select class="form-control" name="status" id="statusSelect">
                                    <option value="" selected disabled>--select--</option>
                                    <option value="active" {{ (old('status', $employee->status ?? '') === 'active') ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ (old('status', $employee->status ?? '') === 'inactive') ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Avatar -->
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="avatarInput" class="form-label">Avatar</label>
                                <input class="form-control" type="file" name="avatar" id="avatarInput">
                            </div>
                        </div>

                    </div> <!-- row -->

                    <!-- Buttons -->
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

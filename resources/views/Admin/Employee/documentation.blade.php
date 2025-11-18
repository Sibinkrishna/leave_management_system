@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Upload Employee Documents: {{ $employee->name }}</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Employees</a></li>
                    <li class="breadcrumb-item active">Documents</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Employee Documents</h4>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card-body pt-0">
                <form action="{{ route('admin.employee.uploadDocuments', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-2 gy-md-3">

                        <!-- Bank Details -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                   name="bank_name" value="{{ old('bank_name') }}" placeholder="Enter bank name">
                            @error('bank_name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                                   name="account_number" value="{{ old('account_number') }}" placeholder="Enter account number">
                            @error('account_number')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">IFSC Code</label>
                            <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" 
                                   name="ifsc_code" value="{{ old('ifsc_code') }}" placeholder="Enter IFSC code">
                            @error('ifsc_code')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Branch Name</label>
                            <input type="text" class="form-control @error('branch_name') is-invalid @enderror" 
                                   name="branch_name" value="{{ old('branch_name') }}" placeholder="Enter branch name">
                            @error('branch_name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Aadhar & PAN Details -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Aadhar Number</label>
                            <input type="text" class="form-control @error('adhar_no') is-invalid @enderror" 
                                   name="adhar_no" value="{{ old('adhar_no') }}" placeholder="Enter 12-digit Aadhar number">
                            @error('adhar_no')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">PAN Number</label>
                            <input type="text" class="form-control @error('pan_no') is-invalid @enderror" 
                                   name="pan_no" value="{{ old('pan_no') }}" placeholder="Enter PAN number">
                            @error('pan_no')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File Uploads -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Aadhar Card (Image/PDF)</label>
                            <input type="file" class="form-control @error('adhar_card') is-invalid @enderror" 
                                   name="adhar_card" accept=".jpg,.jpeg,.png,.pdf">
                            @error('adhar_card')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">PAN Card (Image/PDF)</label>
                            <input type="file" class="form-control @error('pan_card') is-invalid @enderror" 
                                   name="pan_card" accept=".jpg,.jpeg,.png,.pdf">
                            @error('pan_card')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Passport Size Photo</label>
                            <input type="file" class="form-control @error('passport_photo') is-invalid @enderror" 
                                   name="passport_photo" accept=".jpg,.jpeg,.png">
                            @error('passport_photo')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <label class="form-label">Bank Document (Optional)</label>
                            <input type="file" class="form-control @error('bank_doc') is-invalid @enderror" 
                                   name="bank_doc" accept=".jpg,.jpeg,.png,.pdf">
                            @error('bank_doc')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Submit Documents</button>
                        <a href="{{ route('admin.employee.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

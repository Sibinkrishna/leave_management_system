@extends('Admin.Layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Employee Documentation: {{ $employee->name }}</h4>
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

<div class="row justify-content-center mt-4">
    <div class="col-md-12 col-lg-10">
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Photo & Name -->
                <div class="text-center mb-4">
                    <img src="{{ $employee->passport_photo ? asset('storage/'.$employee->passport_photo) : asset('storage/default-avatar.png') }}"
                         alt="Photo" class="rounded-circle img-fluid" width="130">

                    <h4 class="mt-2">{{ $employee->name }}</h4>
                    <span class="text-muted">{{ $employee->designation }}</span>
                </div>

                <hr>

                <!-- MAIN DETAILS (STYLE LIKE IMAGE) -->
                <h5 class="mb-3">Employee Details</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">D.O.J</th>
                        <td>{{ $employee->joining_date ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Salary</th>
                        <td>{{ $employee->salary ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $employee->address ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Blood Group</th>
                        <td>{{ $employee->blood_group ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $employee->email ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Father Name</th>
                        <td>{{ $employee->father_name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Mother Name</th>
                        <td>{{ $employee->mother_name ?? '--' }}</td>
                    </tr>
                </table>

                <hr>

                <!-- BANK DETAILS -->
                <h5 class="mb-3">Bank Details</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Bank Name</th>
                        <td>{{ $employee->bank_name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>Branch</th>
                        <td>{{ $employee->branch_name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>A/C Number</th>
                        <td>{{ $employee->account_number ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th>IFSC Code</th>
                        <td>{{ $employee->ifsc_code ?? '--' }}</td>
                    </tr>

                    @if($employee->bank_doc)
                    <tr>
                        <th>Bank Document</th>
                        <td><a href="{{ asset('storage/'.$employee->bank_doc) }}" target="_blank">View Document</a></td>
                    </tr>
                    @endif
                </table>

                <hr>

                <!-- AADHAR DETAILS -->
                <h5 class="mb-3">Aadhar Details</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Aadhar Number</th>
                        <td>{{ $employee->adhar_no ?? '--' }}</td>
                    </tr>

                    @if($employee->adhar_card)
                    <tr>
                        <th>Aadhar Card</th>
                        <td><a href="{{ asset('storage/'.$employee->adhar_card) }}" target="_blank">View Document</a></td>
                    </tr>
                    @endif
                </table>

                <hr>

                <!-- PAN DETAILS -->
                <h5 class="mb-3">PAN Details</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">PAN Number</th>
                        <td>{{ $employee->pan_no ?? '--' }}</td>
                    </tr>

                    @if($employee->pan_card)
                    <tr>
                        <th>PAN Card</th>
                        <td><a href="{{ asset('storage/'.$employee->pan_card) }}" target="_blank">View Document</a></td>
                    </tr>
                    @endif
                </table>

                <div class="text-end mt-4">
                    <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary">Back</a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

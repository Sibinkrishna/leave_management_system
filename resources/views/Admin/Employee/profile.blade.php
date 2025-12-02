@extends('Admin.Layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
     <div class="page-title-box d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
        <h4 class="page-title mb-0">Profile</h4>

        <!-- ✅ Clean Back Button -->
        <a href="{{ route('admin.employee.index') }}" 
           class="btn btn-outline-dark btn-sm d-flex align-items-center"
           style="padding: 2px 10px; border-radius: 6px;">
            <i class="las la-arrow-left me-1"></i> Back
        </a>
    </div>


                <div class="">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Approx</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>                                
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div><!--end row-->

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">  
                <div class="card-body p-4 rounded text-center img-bg" 
                     style="background-image: url(https://protoverify.com/wp-content/uploads/2023/08/Employee-Background-Verification-in-India-A-Guide-for-Employers.jpg);
                            background-position: 0 20%;
                            background-repeat: no-repeat;
                            background-size: cover;
                            height: 180px;">
                </div><!--end card-body-->
                <div class="position-relative">
                    <div class="shape overflow-hidden text-card-bg">
                        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                        </svg>
                    </div>
                </div>
                <div class="card-body mt-n6">
                    <div class="row align-items-center">                                        
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/'.$employee->avatar) }}" alt="" class="rounded-circle img-fluid" width="130">
                                </div>
                                <div class="flex-grow-1 text-truncate ms-3 align-self-end"> 
                                    <h5 class="m-0 fs-3 fw-bold">{{ $employee->name }}</h5>  
                                    <h6>{{ $employee->designation }}</h6>                                                                                                                               
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->

                    <div class="row align-items-center">                                        
                        <div class="col-lg-12">
                            <div class="mt-3">
                                <div class="mb-2 d-flex align-items-center">
                                    <i class="iconoir-mail-out fs-20 me-1"></i>
                                    <span class="text-body fw-semibold">Email:</span> {{ $employee->email }}
                                </div>
                                <div class="text-body mb-2 d-flex align-items-center">
                                    <i class="iconoir-phone fs-20 me-1"></i>
                                    <span class="text-body fw-semibold">Phone: </span> {{ $employee->phone }}
                                </div>
                                <div class="mb-2 d-flex align-items-center">
                                    <i class="iconoir-calendar fs-20 me-1"></i>
                                    <span class="text-body fw-semibold">Join Date: </span>
                                    <span class="text-dark ms-1">{{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}</span>
                                </div>

                                <!-- New Fields -->
                                <div class="mb-2 d-flex align-items-center">
                                    <i class="iconoir-map-pin fs-20 me-1"></i>
                                    <span class="text-body fw-semibold">Address: </span> {{ $employee->address ?? 'N/A' }}
                                </div>
                                <div class="mb-2 d-flex align-items-center">
                                    <i class="iconoir-building fs-20 me-1"></i>
                                    <span class="text-body fw-semibold">Department: </span> {{ $employee->department->name ?? 'N/A' }}
                                </div>
                                <div class="mb-2 d-flex align-items-center">
                                    <i class="iconoir-check-circle fs-20 me-1"></i>
                                    <span class="text-body fw-semibold">Status: </span> {{ $employee->status ?? 'N/A' }}
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->  
            </div><!--end card--> 
        </div> <!--end col--> 
<div class="col-md-8">
    <div class="tab-content">
        <div class="tab-pane active" id="documents" role="tabpanel">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Employee Documentation</h5>

                            <!-- BANK DETAILS -->
                            <h6 class="mb-2">Bank Details</h6>
                            <table class="table table-bordered mb-3">
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
                                    <td><a href="{{ asset('storage/'.$employee->bank_doc) }}" target="_blank">
                                View <i class="las la-download"></i></td>
                                </tr>
                                @endif
                            </table>

                            <!-- AADHAR DETAILS -->
                            <h6 class="mb-2">Aadhar Details</h6>
                            <table class="table table-bordered mb-3">
                                <tr>
                                    <th width="30%">Aadhar Number</th>
                                    <td>{{ $employee->adhar_no ?? '--' }}</td>
                                </tr>
                                @if($employee->adhar_card)
                                <tr>
                                    <th>Aadhar Card</th>
                                    <td> <a href="{{ asset('storage/'.$employee->adhar_card) }}" target="_blank">
                                View <i class="las la-download"></i></td>
                                </tr>
                                @endif
                            </table>

                            <!-- PAN DETAILS -->
                            <h6 class="mb-2">PAN Details</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">PAN Number</th>
                                    <td>{{ $employee->pan_no ?? '--' }}</td>
                                </tr>
                                @if($employee->pan_card)
                                <tr>
                                    <th>PAN Card</th>
                                    <td> <a href="{{ asset('storage/'.$employee->pan_card) }}" target="_blank">
                                View <i class="las la-download"></i></td>
                                </tr>
                                @endif
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

    
@endsection

@extends('Admin.Layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Profile</h4>
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
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="post" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col">
                                            <p class="text-dark mb-1 fw-semibold">Views</p>
                                            <h3 class="my-2 fs-24 fw-bold">24k</h3>
                                            <p class="mb-0 text-truncate text-muted">
                                                <i class="iconoir-bell text-warning fs-18"></i>
                                                <span class="text-dark fw-semibold">1500</span> New subscribers this week
                                            </p>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                                <i class="iconoir-eye fs-30 align-self-center text-muted"></i>
                                            </div>                                                                    
                                        </div>
                                    </div> 
                                </div><!--end card-body--> 
                            </div><!--end card-->   
                        </div><!--end col-->
                    </div><!--end row--> 
                </div>
            </div> 
        </div> <!--end col-->                                                       
    </div><!--end row-->                      
</div>
@endsection

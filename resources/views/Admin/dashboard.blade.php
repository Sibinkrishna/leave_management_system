@extends('Admin.Layouts.app')
@section('content')
<style>
    body {
        background: #f9fbfd;
        font-family: 'Poppins', sans-serif;
        color: #333;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        text-align: center;
        height: 150px;
        /* width: 150px; */
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }

    .summary-card h3 {
        font-size: 2rem;
        font-weight: bold;
        color: #1976d2;
    }

    .summary-card p {
        margin: 0;
        color: #666;
    }

    /* ✅ Quick Attendance section */
    .quick-attendance-row {
        display: flex;
        justify-content: flex-start;
        margin-top: 20px;
        
        
    }

    .checkin-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        width: 100;
        max-width: 300px; /* same width as summary cards */
        height: 150px; /* same height */
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .checkin-card h4,
    .checkin-card p {
        color: #000;
        margin-bottom:10px;
    }

    /* ✅ Two buttons side by side */
    .attendance-buttons {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 10px;
    }

    .checkin-btn,
    .checkout-btn {
        flex: 1;
        border: none;
        border-radius: 40px;
        padding: 10px 0;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .checkin-btn {
        background: #2e7d32;
    }

    .checkin-btn:hover {
        background: #1b5e20;
    }

    .checkout-btn {
        background: #c62828;
    }

    .checkout-btn:hover {
        background: #8e0000;
    }

    @media (max-width: 768px) {
        .quick-attendance-row {
            justify-content: center;
        }
    }@extends('Admin.Layouts.app')

@section('content')


<div class="page-title-box">
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="#">Approx</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    <h4 class="page-title">Dashboard</h4>
</div>

<div class="row justify-content-center">

    <!-- Quick Attendance Box -->
    <div class="col-lg-7">
        <div class="card bg-globe-img">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-semibold mb-0">Quick Attendance</h4>
                </div>
                <h3 class="fw-bold mb-1">Mark your presence for the day</h3>
                <p class="text-muted mb-4">Track your daily attendance easily</p>

                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-soft-primary w-50">Check In</button>
                    <button type="button" class="btn btn-soft-danger w-50">Check Out</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Boxes -->
    <div class="col-lg-5">
        <div class="row justify-content-center">

            <!-- Total Days Recorded -->
            <div class="col-md-6 col-lg-6">
                <div class="card bg-corner-img">
                    <div class="card-body">
                        <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Days Recorded</p>
                        <h4 class="mt-1 mb-0 fw-medium">{{ $attendances->count() }}</h4>
                        <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-primary rounded mt-2">
                            <i class="iconoir-calendar fs-22 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Present -->
            <div class="col-md-6 col-lg-6">
                <div class="card bg-corner-img">
                    <div class="card-body">
                        <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Present</p>
                        <h4 class="mt-1 mb-0 fw-medium">{{ $attendances->where('status','present')->count() }}</h4>
                        <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-success rounded mt-2">
                            <i class="iconoir-check-circle fs-22 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absent -->
            <div class="col-md-6 col-lg-6">
                <div class="card bg-corner-img">
                    <div class="card-body">
                        <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Absent</p>
                        <h4 class="mt-1 mb-0 fw-medium">{{ $attendances->where('status','absent')->count() }}</h4>
                        <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-danger rounded mt-2">
                            <i class="iconoir-cancel fs-22 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Minutes Worked -->
            <div class="col-md-6 col-lg-6">
                <div class="card bg-corner-img">
                    <div class="card-body">
                        <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Minutes Worked</p>
                        <h4 class="mt-1 mb-0 fw-medium">{{ $attendances->sum('duration_minutes') ?? 0 }}</h4>
                        <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-warning rounded mt-2">
                            <i class="iconoir-clock fs-22 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end row -->
    </div> <!-- end col-lg-5 -->

</div> <!-- end row -->

@endsection

</style>
@if(Auth::user()->role == 'employee')
<div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card  bg-welcome-img overflow-hidden">
                                    <div class="card-body">
                                        <div class="">                                            
                                            <h3 class="text-white fw-semibold fs-20 lh-base">Upgrade you plan for
                                            <br>Great experience</h3>
                                            <a href="#" class="btn btn-sm btn-danger">Upgarde Now</a>
                                            <img src="assets/images/extra/fund.png" alt="" class=" mb-n4 float-end" height="107"> 
                                        </div>
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="card bg-globe-img">
                                    <div class="card-body">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fs-16 fw-semibold">Balance</span>
                                                <form class="">
                                                    <div>
            <div class="dynamic-select example-select" id="dynamic-select" style="">
                <input type="hidden" name="example-select" value="1">
                <div class="dynamic-select-header" style="">
                    
                    <img src="assets/images/logos/m-card.png" alt="xx25" class="" style="">
                    <span class="dynamic-select-option-text">xx25</span>
                
                </div>
                <div class="dynamic-select-options" style="">
                <div class="dynamic-select-option dynamic-select-selected" data-value="1" style="width:100%;">
                    
                    <img src="assets/images/logos/m-card.png" alt="xx25" class="" style="">
                    <span class="dynamic-select-option-text">xx25</span>
                
                </div>
            
                <div class="dynamic-select-option" data-value="2" style="width:100%;">
                    
                    <img src="assets/images/logos/ame-bank.png" alt="xx56" class="" style="">
                    <span class="dynamic-select-option-text">xx56</span>
                
                </div>
            </div>
            </div>
        </div>
                                                </form>
                                            </div>
                                            
                                            <h4 class="my-2 fs-24 fw-semibold">122.5692.00 <small class="font-14">BTC</small></h4>                                            
                                            <p class="mb-3 text-muted fw-semibold">
                                                <span class="text-success"><i class="fas fa-arrow-up me-1"></i>11.1%</span> Outstanding balance boost
                                            </p> 
                                            <button type="submit" class="btn btn-soft-primary">Transfer</button>
                                            <button type="button" class="btn btn-soft-danger">Request</button> 
                                        </div>
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end col-->
                    <div class="col-lg-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-lg-6">
                                <div class="card bg-corner-img">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-9">
                                                <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Revenue</p>
                                                <h4 class="mt-1 mb-0 fw-medium">$8365.00</h4>
                                            </div>
                                            <!--end col-->
                                            <div class="col-3 align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-primary rounded mx-auto">
                                                    <i class="iconoir-dollar-circle fs-22 align-self-center mb-0 text-primary"></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->
                            <div class="col-md-6 col-lg-6">
                                <div class="card bg-corner-img">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-9">
                                                <p class="text-muted text-uppercase mb-0 fw-normal fs-13">New Order</p>
                                                <h4 class="mt-1 mb-0 fw-medium">722</h4>
                                            </div>
                                            <!--end col-->
                                            <div class="col-3 align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-info rounded mx-auto">
                                                    <i class="iconoir-cart fs-22 align-self-center mb-0 text-info"></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->
                            <div class="col-md-6 col-lg-6">
                                <div class="card bg-corner-img">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-9">
                                                <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Sessions</p>
                                                <h4 class="mt-1 mb-0 fw-medium">181</h4>
                                            </div>
                                            <!--end col-->
                                            <div class="col-3 align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-warning rounded mx-auto">
                                                    <i class="iconoir-percentage-circle fs-22 align-self-center mb-0 text-warning"></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <!--end col-->
        
                            <div class="col-md-6 col-lg-6">
                                <div class="card bg-corner-img">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-9">
                                                <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Avg. Order value</p>
                                                <h4 class="mt-1 mb-0 fw-medium">$1025.50</h4>
                                            </div>
                                            <!--end col-->
                                            <div class="col-3 align-self-center">
                                                <div class="d-flex justify-content-center align-items-center thumb-md border-dashed border-danger rounded mx-auto">
                                                    <i class="iconoir-hexagon-dice fs-22 align-self-center mb-0 text-danger"></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div>
                                <!--end card-->
                            </div><!--end col-->        
                        </div>
                        <!--end row-->
                    </div><!--end col-->
                    
                </div>
<div class="container-fluid py-4">
    <div class="dashboard-header">
        <h2 class="fw-bold text-dark">Employee Attendance</h2>
        <p class="text-muted">Track your working hours and attendance record in style</p>
    </div>

    <!-- Summary Cards Row -->
    <div class="summary-cards">
        <div class="summary-card">
            <h3>{{ $attendances->count() }}</h3>
            <p>Total Days Recorded</p>
        </div>
        <div class="summary-card">
            <h3>{{ $attendances->where('status','present')->count() }}</h3>
            <p>Present</p>
        </div>
        <div class="summary-card">
            <h3>{{ $attendances->where('status','absent')->count() }}</h3>
            <p>Absent</p>
        </div>
        <div class="summary-card">
            <h3>{{ $attendances->sum('duration_minutes') ?? 0 }}</h3>
            <p>Total Minutes Worked</p>
        </div>
    </div>

    <!-- ✅ Quick Attendance Box -->
    <div class="quick-attendance-row">
        <div class="checkin-card">
            <div>
                <h4 class="fw-semibold">Quick Attendance</h4>
                <p>Mark your presence for the day</p>
            </div>
            <div class="attendance-buttons">
                <button class="checkin-btn" data-bs-toggle="modal" data-bs-target="#checkInModal">Check In</button>
                <button class="checkout-btn" data-bs-toggle="modal" data-bs-target="#checkOutModal">Check Out</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection


    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>/ --}}

@extends('Admin.Layouts.app')

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

@if(Auth::user()->role == 'employee')

<div class="row justify-content-center">
    <!-- Quick Attendance Box -->
    <div class="col-lg-7">
        <div class="card bg-globe-img overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-semibold mb-0">Quick Attendance</h4>
                </div>
                <h3 class="fw-bold mb-1"></h3>
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
                    <div class="card-body text-center">
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
                    <div class="card-body text-center">
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
                    <div class="card-body text-center">
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
                    <div class="card-body text-center">
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

@else

<!-- When Not Employee -->
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="row">
            <!-- Upgrade Plan Card -->
            <div class="col-md-6">
                <div class="card bg-welcome-img overflow-hidden">
                    <div class="card-body">
                        <h3 class="text-white fw-semibold fs-20 lh-base">
                            Upgrade your plan for<br>Great experience
                        </h3>
                        <a href="#" class="btn btn-sm btn-danger">Upgrade Now</a>
                        <img src="assets/images/extra/fund.png" alt="" class="mb-n4 float-end" height="107">
                    </div>
                </div>
            </div>

            <!-- Balance Card -->
            <div class="col-md-6">
                <div class="card bg-globe-img">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-16 fw-semibold">Balance</span>
                            <form class="">
                                <!-- Add your form fields if needed -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end col -->
</div> <!-- end row -->

@endif

@endsection

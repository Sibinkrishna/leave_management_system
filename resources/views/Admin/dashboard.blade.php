@extends('Admin.Layouts.app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0">Dashboard</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Smart</a></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ol>
        </div>
    </div>
</div>
<div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card bg-globe-img">
                                    <div class="card-body">
                                        <div>
                                            <h4 class="my-2 fs-24 fw-semibold">Quick Attendance</h4>
                                            {{-- <p class="mb-3 text-muted fw-semibold">
                                                <span class="text-success"><i class="fas fa-arrow-up me-1"></i>11.1%</span> Outstanding balance boost
                                            </p> --}}
                                            <div class="row">
                                                <div class="col-6">
                                                    <form method="POST" action="{{ route('employee.attendance.checkin') }}" id="checkInForm" class="w-50">
                                                    @csrf
                                                    <button type="submit" class="btn btn-soft-primary">Checkin</button>
                                                    </form>
                                                </div>
                                                <div class="col-6">
                                                    <form method="POST" action="{{ route('employee.attendance.checkout') }}" id="checkOutForm" class="w-50">
                                                        @csrf
                                                        <button type="submit" class="btn btn-soft-danger">Checkout</button>
                                                        </form>
                                                </div>
                                            </div>


                                        </div>
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end col-->
                    <div class="col-lg-8">
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

                <script>
document.querySelector('#checkInForm').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Check In?',
        text: "Do you want to check in now?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Check In'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

document.querySelector('#checkOutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Check Out?',
        text: "Do you want to check out now?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Check Out'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>

<!-- ✅ Success / Error Messages -->
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: '{{ session('error') }}',
    showConfirmButton: false,
    timer: 2000
});
</script>
@endif

@endsection

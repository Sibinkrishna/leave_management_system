@extends('Admin.Layouts.app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

   /* DASHBOARD PAGE STYLES */
/* Dashboard Row Layout */
.dashboard-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    align-items: stretch;
}

/* Quick Attendance Card */
.quick-attendance-card {
    flex: 1 1 50%;
    min-width: 250px;
    background-size: cover;
    background-position: center;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);

}

.quick-attendance-card .card-body {
    padding: 2rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

.quick-attendance-card h4 {
    font-size: 22px;
    font-weight: 300;
}

.quick-attendance-card p {
    font-size: 15px;
    color: #6c757d;
}

.quick-attendance-card .btn {
    font-size: 18px;
    font-weight: 500;
    padding: 15px 0;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.quick-attendance-card .btn:hover {
    transform: translateY(-2px);
}

/* Responsive Styles */
/* 🌐 Default (Desktop) */
.summary-box .border {
    width: 55px;
    height: 55px;
}
.summary-box i {
    font-size: 28px;
}

/* 💻 Tablet (768px - 991px) */
@media (max-width: 991px) and (min-width: 768px) {
    .summary-box .border {
        width: 48px;
        height: 48px;
    }
    .summary-box i {
        font-size: 25px;
    }
}

/* 📱 Mobile (481px - 767px) */
@media (max-width: 767px) and (min-width: 481px) {
    .summary-box .border {
        width: 43px;
        height: 43px;
    }
    .summary-box i {
        font-size: 23px;
    }
}

/* 📞 Small Mobile (≤480px) */
@media (max-width: 480px) {
    .summary-box .border {
        width: 38px;
        height: 38px;
    }
    .summary-box i {
        font-size: 21px;
    }
}

/* Admin Dashboard Cards */
.dashboard-row .admin-card {
    flex: 1 1 calc(33.333% - 20px);
    min-width: 250px;
}
</style>
 {{-- DASHBOARD CONTENT --}}
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            @if(Auth::user()->role == 'employee')
                <h4 class="fw-semibold mb-0">{{ $monthName }} {{ $currentYear }}</h4>
            @else
                <h4 class="fw-semibold mb-0"></h4>
            @endif
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>
   {{-- EMPLOYEE DASHBOARD --}}
@if(Auth::user()->role == 'employee')
<div class="container mt-3">
    <div class="row g-3 align-items-stretch">
        <!-- LEFT SIDE: Quick Attendance -->
        <div class="col-lg-6 col-md-12">
            <div class="card bg-globe-img quick-attendance-card overflow-hidden h-100">
                <div class="card-body">
                    <h4 class="fw-semibold mb-3">Quick Attendance</h4>
                    <p class="text-muted mb-4">Track your daily attendance easily</p>

                    <div class="d-flex gap-3">
                        <form method="POST" action="{{ route('employee.attendance.checkin') }}" id="checkInForm" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-soft-primary w-100">Check In</button>
                        </form>

                        <form method="POST" action="{{ route('employee.attendance.checkout') }}" id="checkOutForm" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-soft-danger w-100">Check Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       <!-- RIGHT SIDE: Summary Boxes (2 rows, 4 boxes total) -->
<div class="col-lg-6 col-md-12">
    <div class="row justify-content-center g-3">

        <!-- Box 1 -->
        <div class="col-md-6 col-6">
            <div class="card bg-corner-img border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-muted text-uppercase mb-1 fs-13 fw-semibold">Total Days</p>
                            <h4 class="mb-0 fw-bold">{{ $totalDays }}</h4>
                        </div>
                        <div class="col-3 text-center">
                            <div class="d-flex align-items-center justify-content-center border border-2 border-primary rounded-circle mx-auto"
                                 style="width:32px;height:32px;">
                                <i class="iconoir-calendar fs-18 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Box 2 -->
        <div class="col-md-6 col-6">
            <div class="card bg-corner-img border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-muted text-uppercase mb-1 fs-13 fw-semibold">Present</p>
                            <h4 class="mb-0 fw-bold">{{ $totalPresent }}</h4>
                        </div>
                        <div class="col-3 text-center">
                            <div class="d-flex align-items-center justify-content-center border border-2 border-success rounded-circle mx-auto"
                                 style="width:32px;height:32px;">
                                <i class="iconoir-check-circle fs-18 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Box 3 -->
        <div class="col-md-6 col-6">
            <div class="card bg-corner-img border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-muted text-uppercase mb-1 fs-13 fw-semibold">Absent</p>
                            <h4 class="mb-0 fw-bold">{{ $totalAbsent }}</h4>
                        </div>
                        <div class="col-3 text-center">
                            <div class="d-flex align-items-center justify-content-center border border-2 border-danger rounded-circle mx-auto"
                                 style="width:32px;height:32px;">
                                <i class="iconoir-cancel fs-6 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Box 4 -->
        <div class="col-md-6 col-6">
            <div class="card bg-corner-img border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-muted text-uppercase mb-1 fs-13 fw-semibold" style="white-space: nowrap;">
                            Total Hours
                            </p>
                            <h4 class="mb-0 fw-bold">{{ number_format($totalHoursWorked, 2) }} hr</h4>
                        </div>
                        <div class="col-3 text-center">
                            <div class="d-flex align-items-center justify-content-center border border-2 border-pink rounded-circle mx-auto"
                                 style="width:32px;height:32px;">
                                <i class="iconoir-clock fs-18 text-pink"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- row end -->
</div>

    </div>
</div>
@endif
<!-- =============================
   ADMIN DASHBOARD
============================= -->
@if(Auth::user()->role == 'admin')
<div class="row justify-content-center g-3">
    <!-- Box 1 -->
    <div class="col-md-4 col-lg-4">
        <div class="card bg-corner-img border-0 shadow-sm" style="min-height:160px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-9 d-flex flex-column align-items-center justify-content-center">
                        <p class="text-muted text-uppercase mb-2 fs-13 fw-semibold">Total Employees</p>
                        <h4 class="fw-bold mb-0 text-center">{{ $totalEmployees }}</h4>
                    </div>
                    <div class="col-3 text-center">
                        <div class="d-flex align-items-center justify-content-center border border-2 border-pink rounded-circle mx-auto" style="width:45px;height:40px;">
                            <i class="iconoir-users fs-5 text-pink"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Box 2 -->
    <div class="col-md-4 col-lg-4">
        <div class="card bg-corner-img border-0 shadow-sm" style="min-height:160px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-9 d-flex flex-column align-items-center justify-content-center">
                        <p class="text-muted text-uppercase mb-2 fs-13 fw-semibold">Today's Leaves</p>
                        <h4 class="fw-bold mb-0 text-center">{{ $totalLeavesToday }}</h4>
                    </div>
                    <div class="col-3 text-center">
                        <div class="d-flex align-items-center justify-content-center border border-2 border-danger rounded-circle mx-auto" style="width:45px;height:40px;">
                            <i class="iconoir-calendar fs-4 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Box 3 -->
    <div class="col-md-4 col-lg-4">
        <div class="card bg-corner-img border-0 shadow-sm" style="min-height:160px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-9 d-flex flex-column align-items-center justify-content-center">
                        <p class="text-muted text-uppercase mb-2 fs-13 fw-semibold">Attendance Today</p>
                        <h4 class="fw-bold mb-0 text-center">{{ $totalAttendanceToday }}</h4>
                    </div>
                    <div class="col-3 text-center">
                        <div class="d-flex align-items-center justify-content-center border border-2 border-success rounded-circle mx-auto" style="width:45px;height:40px;">
                            <i class="iconoir-check-circle fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- SweetAlert2 Confirmation --}}

<script>
['checkInForm', 'checkOutForm'].forEach(formId => {
    const form = document.getElementById(formId);
    if (!form) return;

    const isCheckIn = formId === 'checkInForm';
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: isCheckIn ? 'Check In?' : 'Check Out?',
            text: isCheckIn ? 'Do you want to check in now?' : 'Do you want to check out now?',
            icon: isCheckIn ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: isCheckIn ? '#007bff' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isCheckIn ? 'Yes, Check In' : 'Yes, Check Out'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>

<!-- ✅ SweetAlert2 Success/Error -->
@if(session('success'))
<script>
Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', showConfirmButton: false, timer: 2000 });
</script>
@endif

@if(session('error'))
<script>
Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session('error') }}', showConfirmButton: false, timer: 2000 });
</script>
@endif

@endsection

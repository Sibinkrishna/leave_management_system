@extends('Admin.Layouts.app')

@section('content')

<!-- ✅ SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ===== Dashboard Styling ===== */
    .dashboard-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        align-items: stretch;

    }

    /* Quick Attendance Big Card */
    .quick-attendance-card {
        flex: 1 1 50%;
        min-width: 500px;
        background-size: cover;
        background-position: center;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        height: 100%;
        border: 2px solid pink; /* ✅ Correct syntax */

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

    /* Summary Cards Layout */
    .summary-cards {
        flex: 1 1 45%;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        align-items: stretch;

    }

    .summary-cards .card {
        border-radius: 12px;
        transition: 0.3s ease;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
         border: 2px solid pink; /* ✅ Correct syntax */
    }

    .summary-cards .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);

    }

    .card-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;

    }

    .card-header-row h5 {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin: 0;

    }

    .icon-box {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed;
    }

    .icon-blue { border-color: #007bff; color: #007bff; background-color: rgba(0,123,255,0.08); }
    .icon-green { border-color: #28a745; color: #28a745; background-color: rgba(40,167,69,0.08); }
    .icon-red { border-color: #dc3545; color: #dc3545; background-color: rgba(220,53,69,0.08); }
    .icon-orange { border-color: #ffc107; color: #ffc107; background-color: rgba(255,193,7,0.08); }

    .summary-cards h4 {
        font-size: 22px;
        font-weight: 600;
        text-align: center;
        margin: 0;
        color: #000;
    }
    /* ✅ Responsive fix for Quick Attendance Card */
@media (max-width: 992px) {
    .quick-attendance-card {
        min-width: 100%;
        flex: 1 1 100%;
        margin-bottom: 20px;
    }

    .quick-attendance-card .card-body {
        padding: 1.5rem;
    }

    .quick-attendance-card h4 {
        font-size: 18px;
    }

    .quick-attendance-card .btn {
        font-size: 16px;
        padding: 12px 0;
    }
}

@media (max-width: 576px) {
    .dashboard-row {
        flex-direction: column;
        gap: 15px;
    }

    .quick-attendance-card {
        min-width: 100%;
        border-radius: 10px;
    }

    .quick-attendance-card .card-body {
        padding: 1.2rem;
    }

    .quick-attendance-card .d-flex.gap-3 {
        flex-direction: column;
        gap: 10px;
    }

    .quick-attendance-card .btn {
        width: 100%;
        padding: 10px 0;
        font-size: 15px;
    }
}
/* ✅ Responsive & Font Scaling for Quick Attendance Card */

/* 🖥️ Desktop (Default > 992px) */
.quick-attendance-card h4 {
    font-size: 22px;
}
.quick-attendance-card p {
    font-size: 15px;
}
.quick-attendance-card .btn {
    font-size: 18px;
    padding: 15px 0;
}

/* 💻 Tablet View (768px–992px) */
@media (max-width: 992px) and (min-width: 768px) {
    .dashboard-row {
        flex-direction: column;
        gap: 20px;
    }

    .quick-attendance-card {
        flex: 1 1 100%;
        min-width: 100%;
    }

    .quick-attendance-card .card-body {
        padding: 1.8rem;
    }

    .quick-attendance-card h4 {
        font-size: 20px;
    }

    .quick-attendance-card p {
        font-size: 14px;
    }

    .quick-attendance-card .btn {
        font-size: 16px;
        padding: 12px 0;
    }
}

/* 📱 Mobile View (Below 768px) */
@media (max-width: 767px) {
    .dashboard-row {
        flex-direction: column;
        gap: 15px;
    }

    .quick-attendance-card {
        flex: 1 1 100%;
        min-width: 100%;
        border-radius: 12px;
    }

    .quick-attendance-card .card-body {
        padding: 1.3rem;
    }

    .quick-attendance-card h4 {
        font-size: 18px;
    }

    .quick-attendance-card p {
        font-size: 13px;
    }

    .quick-attendance-card .btn {
        font-size: 15px;
        padding: 10px 0;
    }

    .quick-attendance-card .d-flex.gap-3 {
        flex-direction: column;
        gap: 10px;
    }
}

/* 📲 Small Mobile View (Below 480px) */
@media (max-width: 480px) {
    .quick-attendance-card h4 {
        font-size: 17px;
    }

    .quick-attendance-card p {
        font-size: 12.5px;
    }

    .quick-attendance-card .btn {
        font-size: 14px;
        padding: 9px 0;
    }

    .quick-attendance-card .card-body {
        padding: 1rem;
    }
}

</style>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            @if(Auth::user()->role == 'employee')
            <h4 class="fw-semibold mb-0">  {{ $monthName }} {{ $currentYear }}</h4>
            @else
            <h4 class="fw-semibold mb-0">  Dashboard</h4>
            @endif

            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                {{-- <li class="breadcrumb-item active">Pending</li> --}}
            </ol>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-soft-danger  text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Attendance Register</h5>
                <span>({{ Auth::user()->name }})</span>
            </div> --}}

@if(Auth::user()->role == 'employee')

<div class="dashboard-row">
    <!-- ✅ Quick Attendance Card -->
    <div class="card bg-globe-img quick-attendance-card overflow-hidden">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-semibold mb-0">Quick Attendance</h4>
            </div>
            <p class="text-muted mb-4">Track your daily attendance easily</p>

            <div class="d-flex gap-3">
                <!-- ✅ Check In Form -->
                <form method="POST" action="{{ route('employee.attendance.checkin') }}" id="checkInForm" class="w-50">
                    @csrf
                    <button type="submit" class="btn btn-soft-primary w-100">Check In</button>
                </form>

                <!-- ✅ Check Out Form -->
                <form method="POST" action="{{ route('employee.attendance.checkout') }}" id="checkOutForm" class="w-50">
                    @csrf
                    <button type="submit" class="btn btn-soft-danger w-100">Check Out</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ Summary Cards with Icons -->
    <div class="summary-cards">
        <div class="card bg-corner-img">
            <div class="card-header-row">
                <h5>Total Days Recorded</h5>
                <div class="icon-box icon-blue">
                    <i class="iconoir-calendar fs-18"></i>
                </div>
            </div>
           <h4>{{ $totalDays }}</h4>


        </div>

        <div class="card bg-corner-img">
            <div class="card-header-row">
                <h5>Present</h5>
                <div class="icon-box icon-green">
                    <i class="iconoir-check-circle fs-18"></i>
                </div>
            </div>
            <h4>{{ $attendances->where('status','present')->count() }}</h4>
        </div>

        <div class="card bg-corner-img">
            <div class="card-header-row">
                <h5>Absent</h5>
                <div class="icon-box icon-red">
                    <i class="iconoir-cancel fs-18"></i>
                </div>
            </div>
            <h4>{{ $attendances->where('status','absent')->count() }}</h4>
        </div>

        <div class="card bg-corner-img">
            <div class="card-header-row">
                <h5>Total hours Worked</h5>
                <div class="icon-box icon-orange">
                    <i class="iconoir-clock fs-18"></i>
                </div>
            </div>
           <h4>{{ number_format($totalHoursWorked, 2) }} hr</h4>


    </div>
</div>
@else
<style>
/* ✅ Dashboard Styling */
.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.dashboard-card {
    flex: 1 1 250px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.dashboard-card h3 {
    font-size: 28px;
    margin-bottom: 10px;
    color: #333;
}

.dashboard-card p {
    font-size: 16px;
    color: #555;
}

/* ✅ Header */
.dashboard-header {
    background: #ffb6c1;
    color: #000;
    padding: 15px 25px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

@media (max-width: 768px) {
    .dashboard-container {
        flex-direction: column;
    }
}
</style>

<div class="dashboard-header">
    <h4>👩‍💼 Admin Dashboard</h4>
    <span>Welcome, {{ Auth::user()->name ?? 'Admin' }}</span>
</div>

<div class="dashboard-container">
    <div class="dashboard-card">
        <h3>25</h3>
        <p>Total Employees</p>
    </div>
    <div class="dashboard-card">
        <h3>8</h3>
        <p>Leave Requests</p>
    </div>
    <div class="dashboard-card">
        <h3>5</h3>
        <p>Pending Approvals</p>
    </div>
    <div class="dashboard-card">
        <h3>90%</h3>
        <p>Attendance Today</p>
    </div>
</div>


@endif


<!-- ✅ SweetAlert2 Popup Confirmation -->
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

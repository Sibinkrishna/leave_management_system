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
        width: 100%;
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
    }
</style>

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
@endsection

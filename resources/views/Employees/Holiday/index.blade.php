@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">Holiday Calendar</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Holiday</a></li>
                <li class="breadcrumb-item active">Summary</li>
            </ol>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- Black header (same as Leave Sheet) -->
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Holiday @2025</h5>
                <span>({{ Auth::user()->name }})</span>
            </div>

            <!-- White background for content -->
            <div class="card-body" style="background-color: #ffffff;">
                {{-- Centered grid with 3 cards per row --}}
                <div class="d-flex justify-content-center mt-4">
                    <div class="holiday-grid">
                        @php
                            $holidaysByMonth = $holidays->groupBy(function($holiday) {
                                return \Carbon\Carbon::parse($holiday->date)->format('F');
                            });

                            $monthEmojis = [
                                'January' => '❄️',
                                'February' => '❤️',
                                'March' => '🌱',
                                'April' => '🌸',
                                'May' => '🌞',
                                'June' => '🌻',
                                'July' => '🎆',
                                'August' => '☀️',
                                'September' => '🍁',
                                'October' => '🍒',
                                'November' => '🍂',
                                'December' => '🎄',
                            ];
                        @endphp

                        @foreach($holidaysByMonth as $month => $monthHolidays)
                            <div class="card border-primary shadow-sm holiday-card">
                                <div class="card-header text-center bg-white border-bottom-0">
                                    <h5 class="mb-1">{{ $monthEmojis[$month] ?? '📅' }} {{ $month }}</h5>
                                    <small class="text-muted text-decoration-underline">Holidays</small>
                                </div>
                                <div class="card-body p-2">
                                    <ul class="list-group list-group-flush">
                                        @foreach($monthHolidays as $holiday)
                                            <li class="list-group-item p-1 mb-1 text-center border rounded bg-light">
                                                <strong>{{ \Carbon\Carbon::parse($holiday->date)->format('d') }}</strong> - {{ $holiday->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($holidaysByMonth->isEmpty())
                    <p class="text-center text-muted mt-3 mb-0">No holiday records found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* ======= 3-column centered grid layout ======= */
.holiday-grid {
    display: grid;
    grid-template-columns: repeat(3, 220px); /* 3 fixed-width cards per row */
    gap: 5px 30px; /* spacing between boxes (row, column) */
    justify-content: center;
    padding-left: 80px;
    padding-right: 80px;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .holiday-grid {
        grid-template-columns: repeat(2, 220px); /* 2 boxes per row on tablets */
    }
}

@media (max-width: 600px) {
    .holiday-grid {
        grid-template-columns: repeat(1, 220px); /* 1 box per row on mobile */
        padding-left: 20px;
        padding-right: 20px;
    }
}

/* ======= Card styling ======= */
.holiday-card {
    aspect-ratio: 1 / 1;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease-in-out;
    height:230px;
}

.holiday-card:hover {
    transform: translateY(-5px);
}

/* ======= Inner text styling ======= */
.card-header h5 {
    font-weight: 700;
}

.list-group-item {
    font-size: 0.85rem;
    background-color: #f8f9fa !important;
}
</style>
@endsection

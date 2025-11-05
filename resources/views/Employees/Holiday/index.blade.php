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

{{-- Centered grid with 3 cards per row and larger side gaps --}}
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
                'October' => '🎃',
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

<style>
/* Create a 3-column centered grid */
.holiday-grid {
    display: grid;
    grid-template-columns: repeat(3, 220px); /* 3 fixed-width cards per row */
    gap: 12px 24px; /* small gap between boxes (row,col) */
    justify-content: center; /* center the grid horizontally */
    padding-left: 80px;  /* increase side gaps */
    padding-right: 80px; /* increase side gaps */
}

/* Card styling */
.holiday-card {
    aspect-ratio: 1 / 1;
    display: flex;
    flex-direction: column;
}

.card-header h5 {
    font-weight: 700;
}

.list-group-item {
    font-size: 0.85rem;
    background-color: #f8f9fa !important;
}
</style>
@endsection

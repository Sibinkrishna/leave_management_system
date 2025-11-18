@extends('Admin.Layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title"></h4>
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

            <!-- Black Header -->
            <div class="card-header bg-dark text-white d-flex justify-content-between 
                        align-items-center flex-wrap gap-2 py-2 px-3">
                <h5 class="mb-0 fw-bold fs-6">Holiday @2025</h5>
            </div>

            <!-- Content -->
            <div class="card-body bg-white">

                <div class="d-flex justify-content-center mt-4">
                    
                    @php
                        // Group holidays by month
                        $holidaysByMonth = $holidays->groupBy(function ($holiday) {
                            return \Carbon\Carbon::parse($holiday->date)->format('F');
                        });

                        // Emoji mapping
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

                    <div class="holiday-grid">

                        @foreach($holidaysByMonth as $month => $monthHolidays)
                            <div class="card border-primary shadow-sm holiday-card">

                                <div class="card-header text-center bg-white border-bottom-0">
                                    <h5 class="mb-1 fw-bold">
                                        {{ $monthEmojis[$month] ?? '📅' }} {{ $month }}
                                    </h5>
                                    <small class="text-muted text-decoration-underline">Holidays</small>
                                </div>

                                <div class="card-body p-2">
                                    <ul class="list-group list-group-flush">
                                        @foreach($monthHolidays as $holiday)
                                            <li class="list-group-item p-1 mb-1 text-center border rounded bg-light">
                                                <strong>{{ \Carbon\Carbon::parse($holiday->date)->format('d') }}</strong>
                                                – {{ $holiday->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

                @if($holidaysByMonth->isEmpty())
                    <p class="text-center text-muted mt-3 mb-0">
                        No holiday records found.
                    </p>
                @endif

            </div>
        </div>
    </div>
</div>

<style>
/* ===== 3-Column Center Grid (Desktop) ===== */
.holiday-grid {
    display: grid;
    grid-template-columns: repeat(3, 220px);
    gap: 15px 30px;
    justify-content: center;
    padding: 0 80px;
}

/* ===== Tablet ===== */
@media (max-width: 992px) {
    .holiday-grid {
        grid-template-columns: repeat(2, 220px);
        padding: 0 30px;
    }
}

/* ===== Mobile ===== */
@media (max-width: 600px) {
    .holiday-grid {
        grid-template-columns: repeat(1, 220px);
        padding: 0 20px;
    }
}

/* ===== Card Style ===== */
.holiday-card {
    aspect-ratio: 1 / 1;
    display: flex;
    flex-direction: column;
    height: 230px;
    transition: transform 0.2s ease-in-out;
}

.holiday-card:hover {
    transform: translateY(-5px);
}

/* ===== Month Header ===== */
.card-header h5 {
    font-weight: 700;
}

/* ===== List Styling ===== */
.list-group-item {
    font-size: 0.85rem;
    background-color: #f8f9fa !important;
}
</style>

@endsection

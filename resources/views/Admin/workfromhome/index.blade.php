@extends('Admin.Layouts.app')

@section('content')
<!-- ✅ Page Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0"></h4>
            <ol class="breadcrumb mb-0 ms-auto"> <!-- ✅ Always right side -->
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active">WFH Summary</li>
            </ol>
        </div>
    </div>
</div>

<div class="row justify-content-center mb-2">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                 <h4 class="card-title">WFH Records List</h4>

                <!-- ✅ Updated Filter Form -->
<form method="GET" action="{{ route('admin.wfh.index') }}" class="d-flex align-items-center gap-2">
    <input 
        type="date" 
        name="date" 
        class="form-control form-control-sm"
        value="{{ request('date') }}"
        style="width: auto;"
    >

    <button type="submit" class="btn btn-sm btn-light text-dark border">
        <i class="bi bi-search"></i> Filter
    </button>
</form>

            </div>

            <!-- Table -->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use Carbon\Carbon;
                                $grouped = $entries->groupBy(function($e) {
                                    return ($e->user->id ?? 'N/A') . '|' . ($e->user->name ?? 'N/A') . '|' . $e->entry_date;
                                });
                            @endphp

                            @forelse($grouped as $key => $records)
                                @php
                                    [$id, $name, $date] = explode('|', $key);
                                    $dateFormatted = Carbon::parse($date)->format('d-m-Y');

                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $name }}</td>
                                    <td>{{ $dateFormatted }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-dark"
                                          style="width:32px; height:25px; padding:1px 0;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailsModal"
                                            data-employee="{{ $name }}"
                                            data-date="{{ $dateFormatted }}"
                                            data-details='@json($records->map(fn($r)=>[
                                                "time"=>$r->work_time,
                                                "task"=>$r->task_summary,
                                                "status"=>$r->notes
                                            ]))'>
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Work From Home records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h6 class="modal-title">Work From Home Details</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Employee:</strong> <span id="modalEmployee"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <hr>
        <div id="modalDetails"></div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var modal = document.getElementById('detailsModal');
    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var employee = button.getAttribute('data-employee');
        var date = button.getAttribute('data-date');
        var details = JSON.parse(button.getAttribute('data-details'));

        // ✅ Sort by actual time (AM/PM)
        details.sort(function(a, b) {
            const parseTime = t => {
                const [time, modifier] = t.split(' ');
                let [hours, minutes] = time.split(':').map(Number);
                if (modifier === 'PM' && hours !== 12) hours += 12;
                if (modifier === 'AM' && hours === 12) hours = 0;
                return hours * 60 + minutes;
            };
            return parseTime(a.time) - parseTime(b.time);
        });

        document.getElementById('modalEmployee').textContent = employee;
        document.getElementById('modalDate').textContent = date;

        // ✅ Table generation
        let html = '<table class="table table-bordered text-center">';
        html += '<thead><tr><th>Work Duration</th><th>Task Summary</th><th>Status</th></tr></thead><tbody>';

        details.forEach(function(item){
            let timeText = (item.time || '').trim();
            let taskName = (item.task || '').trim();
            let statusText = (item.status || '—').trim();

            // ✅ Parse time to 24hr for checking
            const parseTimeToMinutes = t => {
                const [time, modifier] = t.split(' ');
                let [hours, minutes] = time.split(':').map(Number);
                if (modifier === 'PM' && hours !== 12) hours += 12;
                if (modifier === 'AM' && hours === 12) hours = 0;
                return hours * 60 + minutes;
            };

            const timeInMinutes = parseTimeToMinutes(timeText);

            // ✅ If time between 1:00 PM and 2:00 PM → Lunch Time
            if (timeInMinutes >= 13 * 60 && timeInMinutes < 14 * 60) {
                statusText = 'Lunch Time';
            }

            let rowStyle = '';
            if (statusText === 'Lunch Time') {
                rowStyle = 'style="background-color:#fff3cd;font-weight:600;color:#856404;"';
            }

            html += `<tr ${rowStyle}>
                        <td>${item.time}</td>
                        <td>${taskName}</td>
                        <td>${statusText}</td>
                     </tr>`;
        });

        html += '</tbody></table>';
        document.getElementById('modalDetails').innerHTML = html;
    });
});
</script>
<style>
/* ✅ Default (Desktop ≥1025px) */
.table th, .table td {
    vertical-align: middle;
    font-size: 13px;
}
.card-title, .page-title, .fw-bold {
    font-size: 18px;
}
.btn, .form-control {
    font-size: 14px;
}
.modal-body, .modal-title {
    font-size: 15px;
}
.bi-eye {
    font-size: 16px; /* action icon */
}

/* ✅ Tablet (768px–1024px) */
@media (max-width: 1024px) and (min-width: 768px) {
    .table th, .table td {
        font-size: 12px;
        padding: 0.55rem 0.6rem;
    }
    .card-title, .page-title, .fw-bold {
        font-size: 17px;
    }
    .btn, .form-control {
        font-size: 13px;
        padding: 6px 10px;
    }
    .modal-body, .modal-title {
        font-size: 14px;
    }
    .bi-eye {
        font-size: 14px;
    }
}

/* ✅ Mobile (<768px) */
@media (max-width: 767px) {
    .table th, .table td {
        font-size: 10.5px;
        padding: 0.45rem 0.4rem;
    }
    .card-title, .page-title, .fw-bold {
        font-size: 15px;
        text-align: center;
    }
    .btn, .form-control {
        font-size: 12px;
        padding: 5px 8px;
    }
    .modal-body, .modal-title {
        font-size: 13px;
    }
    .bi-eye {
        font-size: 12px; /* smaller icon for mobile */
    }
}
</style>




@endsection

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
                <li class="breadcrumb-item active">Leave Applications</li>
            </ol>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
           <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">

    <h5 class="card-title mb-0">Employee Leave List</h5>

    <!-- 🔍 Search Box Right Side -->
    <form method="GET" 
          action="{{ route('admin.leaves.pending') }}" 
          class="d-flex mt-2 mt-md-0">

        <input type="text" name="search"
               class="form-control form-control-sm"
               style="max-width:180px;"
               placeholder="Search…" 
               value="{{ $search ?? '' }}">

        <button class="btn btn-primary btn-sm ms-2" type="submit">Search</button>

        @if(!empty($search))
            <a href="{{ route('admin.leaves.pending') }}" 
               class="btn btn-secondary btn-sm ms-2">Reset</a>
        @endif
    </form>
</div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">Employee</th>
                                <th>Leave Type</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaveApplications as $leave)
                                <tr>
                                    <td class="text-start">{{ $leave->user->name ?? '-' }}</td>
                                    <td>{{ $leave->leaveType->name ?? '-' }}</td>
                                    <td>{{ $leave->days = floatval($leave->days); }}</td> 

                                    <td>
                                        @if($leave->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($leave->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button
                                            class="btn btn-outline-secondary btn-sm viewBtn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewLeaveModal"
                                            data-subject="{{ $leave->subject ?? 'N/A' }}"
                                            data-reason="{{ $leave->reason ?? 'N/A' }}"
                                            data-start="{{ \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') }}"
                                            data-end="{{ \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') }}"
                                            data-id="{{ $leave->id }}"
                                            data-status="{{ $leave->status }}"
                                            data-certificate="{{ $leave->medical_certificate_path ?? '' }}"

                                        >
                                            <i class="las la-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted">No leave applications found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Modal --}}
<div class="modal fade" id="viewLeaveModal" tabindex="-1" aria-labelledby="viewLeaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-white border-bottom">
                <h6 class="modal-title" id="viewLeaveLabel">Leave Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6><strong>Start Date:</strong></h6>
                        <p id="modalStart" class="border rounded p-2 bg-light"></p>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>End Date:</strong></h6>
                        <p id="modalEnd" class="border rounded p-2 bg-light"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <h6><strong>Subject:</strong></h6>
                    <p id="modalSubject" class="border rounded p-2 bg-light"></p>
                </div>
                <div>
                    <h6><strong>Reason:</strong></h6>
                    <p id="modalReason" class="border rounded p-2 bg-light"></p>
                </div>
                 <div class="mt-3">
                    <h6><strong>Medical Certificate:</strong></h6>
                    <p id="modalCertificate" class="border rounded p-2 bg-light"></p>
                </div>
            </div>
            <div class="modal-footer" id="modalActions">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Script --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("viewLeaveModal");
    modal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        const subject = button.getAttribute("data-subject") || "N/A";
        const reason = button.getAttribute("data-reason") || "N/A";
        const start = button.getAttribute("data-start") || "N/A";
        const end = button.getAttribute("data-end") || "N/A";
        const id = button.getAttribute("data-id");
        const status = (button.getAttribute("data-status") || '').toLowerCase();
        const certificate = button.getAttribute("data-certificate") || "";

        

        document.getElementById("modalSubject").textContent = subject;
        document.getElementById("modalReason").textContent = reason;
        document.getElementById("modalStart").textContent = start;
        document.getElementById("modalEnd").textContent = end;

          document.getElementById("modalCertificate").innerHTML =
            certificate
                ? `<a href="/storage/${certificate}" target="_blank" class="text-primary fw-bold">View Certificate</a>`
                : `<span class="text-muted">No file uploaded</span>`;
                

        const actionDiv = document.getElementById("modalActions");
        if (status === "pending") {
            actionDiv.innerHTML = `
                <form action="/admin/leaves/${id}/approve" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm me-2">Approve</button>
                </form>
                <form action="/admin/leaves/${id}/reject" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm me-2">Reject</button>
                </form>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            `;
        } else {
            actionDiv.innerHTML = `
                <span class="text-muted me-3">No further action available.</span>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            `;
        }
    });
});
</script>

{{-- ✅ Style --}}
<style>
.table th, .table td {
    vertical-align: middle;
    font-size: 13px; /* ✅ Desktop default */
}

.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border: none;
}

/* ✅ Action (eye) icon button */
.viewBtn {
    padding: 4px 8px;
    border-radius: 6px;
}
.viewBtn i {
    font-size: 16px; /* ✅ Desktop */
    line-height: 1;
}

/* ✅ Tablet View (768px - 1024px) */
@media (max-width: 1024px) {
    .table th, .table td {
        font-size: 13px;
        padding: 0.55rem 0.6rem;
    }

    .viewBtn {
        padding: 4px 6px;
    }
    .viewBtn i {
        font-size: 14px; /* smaller on tablet */
    }

    .btn {
        font-size: 13px;
        padding: 5px 8px;
    }
    .badge {
        font-size: 13px;
        padding: 5px 8px;
    }
    .card-title, .page-title {
        font-size: 17px;
    }
}

/* ✅ Mobile View (below 768px) */
@media (max-width: 768px) {
    .table th, .table td {
        font-size: 10.5px;
        padding: 0.4rem 0.4rem;
    }

    /* ✅ Action (eye) icon button */
.viewBtn {
    padding: 2px 5px;
    border-radius: 3px;
    }
    .viewBtn i {
        font-size: 12px; /* ✅ small on mobile */
    }

    .btn {
        font-size: 12px;
        padding: 4px 6px;
    }
    .badge {
        font-size: 11.5px;
        padding: 3px 6px;
    }
    .card-title, .page-title {
        text-align: left;
        font-size: 15px;
    }
}
</style>


@endsection

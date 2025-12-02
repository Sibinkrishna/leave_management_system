@extends('Admin.Layouts.app')

@section('content')
<!-- Page Title -->
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0">Leave Applications</h4>
            <ol class="breadcrumb mb-0 ms-auto">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active">Leave Applications</li>
            </ol>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="card-title mb-0">Employee Leave List</h5>

                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.leaves.pending') }}" class="d-flex mt-2 mt-md-0">
                    <input type="text" name="search"
                           class="form-control form-control-sm"
                           style="max-width:180px;"
                           placeholder="Search…"
                           value="{{ $search ?? '' }}">
                    <button class="btn btn-primary btn-sm ms-2" type="submit">Search</button>
                    @if(!empty($search))
                        <a href="{{ route('admin.leaves.pending') }}" class="btn btn-secondary btn-sm ms-2">Reset</a>
                    @endif
                </form>
            </div>

            <div class="card-body p-0">
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

                        @php $renderedUsers = []; @endphp
                        <tbody>
                        @forelse($leaveApplications as $leave)
                            @php
                                $userId = $leave->user->id ?? null;
                                $showTotals = $userId && !in_array($userId, $renderedUsers);
                                if($showTotals) $renderedUsers[] = $userId;
                            @endphp

                            <tr>
                                <td class="text-start">{{ $leave->user->name ?? '-' }}</td>
                                <td>{{ $leave->leaveType->name ?? '-' }}</td>
                                <td>{{ floatval($leave->days) }}</td>
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
                                    <button class="btn btn-outline-secondary btn-sm viewBtn" ...existing attributes...>
                                        <i class="las la-eye"></i>
                                    </button>

                                    @if($showTotals)
                                        <button class="btn btn-outline-primary btn-sm ms-1 totalsBtn"
                                                data-user-id="{{ $userId }}"
                                                data-user-name="{{ $leave->user->name ?? '' }}">
                                            Totals
                                        </button>
                                    @endif
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

<!-- View Leave Modal -->
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Totals Modal -->
<div class="modal fade" id="totalsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Leave Totals - <span id="totalsUserName"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Leave Type</th>
                                <th>Total Days</th>
                                <th>Used Days</th>
                                <th>Remaining Days</th>
                            </tr>
                        </thead>
                        <tbody id="totalsBody">
                            <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Totals Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const showModal = id => bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).show();

    document.querySelectorAll('.totalsBtn').forEach(btn => {
        btn.addEventListener('click', async function () {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName || 'Employee';
            const tbody = document.getElementById('totalsBody');

            document.getElementById('totalsUserName').textContent = userName;
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">Loading…</td></tr>';

            if(!userId) return alert('User id missing');

            try {
                const resp = await fetch(`{{ url('/admin/leave/totals') }}/${userId}`, { headers: { 'Accept':'application/json' } });
                if(!resp.ok) throw new Error('Network response was not ok');

                const json = await resp.json();

                if(!json.totals?.length) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No leave records.</td></tr>';
                    return showModal('totalsModal');
                }

                tbody.innerHTML = '';
                json.totals.forEach(r => {
                    tbody.innerHTML += `
                        <tr>
                            <td class="text-start">${r.name}</td>
                            <td>${r.total ?? 0}</td>
                            <td>${Number(r.used ?? 0)}</td>
                            <td>${r.remaining ?? 0}</td>
                        </tr>
                    `;
                });

                if(json.totalsRow){
                    const t = json.totalsRow;
                    tbody.innerHTML += `
                        <tr class="fw-bold">
                            <td class="text-start">${t.name}</td>
                            <td>${t.total}</td>
                            <td>${Number(t.used)}</td>
                            <td>${t.remaining}</td>
                        </tr>
                    `;
                }

                showModal('totalsModal');
            } catch(err) {
                console.error(err);
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Failed to load totals.</td></tr>';
                showModal('totalsModal');
            }
        });
    });
});
</script>

{{-- Styles --}}
<style>
.table th, .table td {
    vertical-align: middle;
    font-size: 13px;
}

.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: none;
}
 .viewBtn {
    padding: 4px 8px;
    border-radius: 6px;
}
.viewBtn i {
    font-size: 16px;
}

/* Tablet */
@media(max-width:1024px){
    .table th,.table td{font-size:13px;padding:0.55rem 0.6rem;}
    .viewBtn{padding:4px 6px;}
    .viewBtn i{font-size:14px;}
    .btn{font-size:13px;padding:5px 8px;}
    .badge{font-size:13px;padding:5px 8px;}
}

/* Mobile */
@media(max-width:768px){
    .table th,.table td{font-size:10.5px;padding:0.4rem;}
    .viewBtn{padding:2px 5px;}
    .viewBtn i{font-size:12px;}
    .btn{font-size:12px;padding:4px 6px;}
    .badge{font-size:11.5px;padding:3px 6px;}
    .card-title,.page-title{text-align:left;font-size:15px;}
}
</style>
 @endsection

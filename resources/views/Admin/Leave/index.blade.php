@extends('Admin.Layouts.app')

@section('content')
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

                        <tbody>
                        @forelse($leaveApplications as $leave)
                            <tr id="leaveRow{{ $leave->id }}">
                                <td class="text-start">{{ $leave->user->name ?? '-' }}</td>
                                <td>{{ $leave->leaveType->name ?? '-' }}</td>
                                <td>{{ floatval($leave->days) }}</td>
                                <td class="leave-status text-center">
                                    @if($leave->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($leave->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-outline-secondary btn-sm viewBtn"
                                        data-id="{{ $leave->id }}"
                                        data-employee="{{ $leave->user->name }}"
                                        data-start="{{ $leave->start_date }}"
                                        data-end="{{ $leave->end_date }}"
                                        data-subject="{{ $leave->subject }}"
                                        data-reason="{{ $leave->reason }}"
                                        + data-certificate="{{ $leave->medical_certificate_path }}"
                                        data-status="{{ $leave->status }}">
                                        <i class="las la-eye"></i>
                                    </button>

                                    <button class="btn btn-outline-primary btn-sm ms-1 totalsBtn"
                                        data-user-id="{{ $leave->user->id }}"
                                        data-user-name="{{ $leave->user->name }}">
                                        Totals
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

<!-- VIEW LEAVE MODAL -->
<div class="modal fade" id="viewLeaveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Employee Leave Application Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6><strong>Employee:</strong></h6>
                    <p id="modalEmployee" class="border rounded p-2 bg-light"></p>
                </div>

                <div class="mb-3">
                    <h6><strong>Leave Dates:</strong></h6>
                    <p id="modalDates" class="border rounded p-2 bg-light"></p>
                </div>

                <div class="mb-3">
                    <h6><strong>Subject:</strong></h6>
                    <p id="modalSubject" class="border rounded p-2 bg-light"></p>
                </div>

                <div class="mb-3">
                    <h6><strong>Reason:</strong></h6>
                    <p id="modalReason" class="border rounded p-2 bg-light"></p>
                </div>

             <div class="mb-3">
    <h6><strong>Medical Certificate:</strong></h6>
    <p id="modalCertificate" class="border rounded p-2 bg-light">
        <a id="modalCertificateLink" href="#" target="_blank">No file</a>
    </p>
</div>

            <div class="modal-footer">
                <button id="approveBtn" class="btn btn-success btn-sm" data-id="">Approve</button>
                <button id="rejectBtn" class="btn btn-danger btn-sm" data-id="">Reject</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- TOTALS MODAL -->
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewBtns = document.querySelectorAll('.viewBtn');
    const modal = new bootstrap.Modal(document.getElementById('viewLeaveModal'));

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('modalEmployee').textContent = this.dataset.employee || '-';

            const start = this.dataset.start ? this.dataset.start.split(' ')[0] : '-';
            const end = this.dataset.end ? this.dataset.end.split(' ')[0] : '-';
            document.getElementById('modalDates').textContent = `${start} – ${end}`;

            document.getElementById('modalSubject').textContent = this.dataset.subject || '-';
            document.getElementById('modalReason').textContent = this.dataset.reason || '-';

            // ✅ MEDICAL CERTIFICATE CLICKABLE LINK
            const certificate = this.dataset.certificate;
            const certLink = document.getElementById('modalCertificateLink');

            if (certificate && certificate !== 'null') {
                certLink.href = `/storage/${certificate}`;
                certLink.textContent = 'View Certificate';
            } else {
                certLink.href = '#';
                certLink.textContent = 'No file';
            }

            const approveBtn = document.getElementById('approveBtn');
            const rejectBtn = document.getElementById('rejectBtn');

            approveBtn.dataset.id = this.dataset.id;
            rejectBtn.dataset.id = this.dataset.id;

            // Show/hide approve & reject buttons based on current status
            if (this.dataset.status === 'pending') {
                approveBtn.style.display = 'inline-block';
                rejectBtn.style.display = 'inline-block';
            } else {
                approveBtn.style.display = 'none';
                rejectBtn.style.display = 'none';
            }

            modal.show();
        });
    });

    const updateStatus = async (leaveId, status) => {
        try {
            const token = '{{ csrf_token() }}';

            const url = status === 'approved'
                ? `/admin/leaves/${leaveId}/approve`
                : `/admin/leaves/${leaveId}/reject`;

            const resp = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            });

            const data = await resp.json();
            if (data.success) {
                const row = document.getElementById('leaveRow' + leaveId);
                const badgeCell = row.querySelector('.leave-status');

                badgeCell.innerHTML = status === 'approved'
                    ? '<span class="badge bg-success">Approved</span>'
                    : '<span class="badge bg-danger">Rejected</span>';

                const viewBtn = row.querySelector('.viewBtn');
                viewBtn.dataset.status = status;

                bootstrap.Modal.getInstance(document.getElementById('viewLeaveModal')).hide();
            } else {
                alert('Failed to update status');
            }
        } catch (err) {
            console.error(err);
            alert('Error updating status');
        }
    };

    document.getElementById('approveBtn').addEventListener('click', () => {
        updateStatus(document.getElementById('approveBtn').dataset.id, 'approved');
    });

    document.getElementById('rejectBtn').addEventListener('click', () => {
        updateStatus(document.getElementById('rejectBtn').dataset.id, 'rejected');
    });

    // TOTALS BUTTON
    document.querySelectorAll('.totalsBtn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            document.getElementById('totalsUserName').textContent = userName;

            const tbody = document.getElementById('totalsBody');
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">Loading…</td></tr>';

            try {
                const resp = await fetch(`/admin/leave/totals/${userId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await resp.json();

                if (!json.totals?.length) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No leave records.</td></tr>';
                } else {
                    tbody.innerHTML = '';
                    json.totals.forEach(r => {
                        tbody.innerHTML += `<tr>
                            <td class="text-start">${r.name}</td>
                            <td>${r.total ?? 0}</td>
                            <td>${r.used ?? 0}</td>
                            <td>${r.remaining ?? 0}</td>
                        </tr>`;
                    });
                    const t = json.totalsRow;
                    tbody.innerHTML += `<tr class="fw-bold">
                        <td class="text-start">${t.name}</td>
                        <td>${t.total ?? 0}</td>
                        <td>${t.used ?? 0}</td>
                        <td>${t.remaining ?? 0}</td>
                    </tr>`;
                }

                new bootstrap.Modal(document.getElementById('totalsModal')).show();
            } catch(err) {
                console.error(err);
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Failed to load totals.</td></tr>';
                new bootstrap.Modal(document.getElementById('totalsModal')).show();
            }
        });
    });
});
</script>


@endsection

@extends('Admin.Layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Employee Leave Applications</h5>
        </div>

        <div class="card-body">
            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Days</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveApplications as $key => $leave)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $leave->user->name ?? '-' }}</td>
                            <td>{{ $leave->leaveType->name ?? '-' }}</td>
                            <td>{{ $leave->start_date }}</td>
                            <td>{{ $leave->end_date }}</td>
                            <td>{{ $leave->days }}</td>
                            <td>
                                @if($leave->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($leave->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <button
                                    class="btn btn-outline-primary btn-sm viewBtn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewLeaveModal"
                                    data-subject="{{ $leave->subject ?? 'N/A' }}"
                                    data-reason="{{ $leave->reason ?? 'N/A' }}"
                                    data-id="{{ $leave->id }}"
                                    data-status="{{ $leave->status }}"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">No leave applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal (Subject & Reason only) --}}
<div class="modal fade" id="viewLeaveModal" tabindex="-1" aria-labelledby="viewLeaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h6 class="modal-title" id="viewLeaveLabel">Leave Details</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <h6><strong>Subject:</strong></h6>
                    <p id="modalSubject" class="border rounded p-2 bg-light"></p>
                </div>
                <div>
                    <h6><strong>Reason:</strong></h6>
                    <p id="modalReason" class="border rounded p-2 bg-light"></p>
                </div>
            </div>

            <div class="modal-footer" id="modalActions">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("viewLeaveModal");
    modal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        // Get attributes
        const subject = button.getAttribute("data-subject") || "N/A";
        const reason = button.getAttribute("data-reason") || "N/A";
        const id = button.getAttribute("data-id");
        const status = (button.getAttribute("data-status") || '').toLowerCase();

        // Fill modal content
        document.getElementById("modalSubject").textContent = subject;
        document.getElementById("modalReason").textContent = reason;

        // Render buttons dynamically
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
@endsection

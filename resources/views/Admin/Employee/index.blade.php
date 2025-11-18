@extends('Admin.Layouts.app')

@section('content')
<!-- ✅ Page Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="page-title mb-2 mb-md-0"></h4>
            <ol class="breadcrumb mb-0 ms-auto"> <!-- ✅ Always right side -->
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">Form</a></li>
                <li class="breadcrumb-item active">Employee List</li>
            </ol>
        </div>
    </div>
</div>



<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center mb-6">
                    <div class="col">
                        <h4 class="card-title">Employee Table</h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('admin.employee.create') }}" class="btn btn-primary">
                            Add Employee
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                @if(strtolower($employee->status) === 'active')
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->designation }}</td>
                                    <td>{{ ucfirst($employee->status) }}</td> <!-- ✅ Normal text -->
                                    <td class="text-end">
                                        <a href="{{ route('admin.employee.show', $employee->id) }}">
                                            <i class="las la-eye text-secondary font-16"></i>
                                        </a>
                                        <a href="{{ route('admin.employee.edit', $employee->id) }}">
                                            <i class="las la-pen text-secondary font-16"></i>
                                        </a>
                                        <form action="{{ route('admin.employee.destroy', $employee->id) }}" 
                                              method="POST" style="display:inline">
                                            @csrf
                                            <button type="button" style="all: unset;" 
                                                onclick="Swal.fire({
                                                    title: 'Delete?',
                                                    text: 'Are you sure you want to delete {{ $employee->name }}?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: 'rgba(255, 73, 194, 0.72)',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Yes, Delete'
                                                }).then((result) => { if(result.isConfirmed){ this.form.submit(); }})">
                                                <i class="las la-trash-alt text-secondary font-16"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No active employees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Base font size for desktop */
.table th, .table td {
    vertical-align: middle;
    font-size: 13px;
}

/* Tablet: 768px - 1024px */
@media (max-width: 1024px) and (min-width: 768px) {
    .table th, .table td {
        font-size: 12px;
    }
    .card-title, .page-title {
        font-size: 18px;
    }
    .btn {
        font-size: 14px;
        padding: 6px 12px;
    }
}

/* Mobile: <768px */
@media (max-width: 767px) {
    .table th, .table td {
        font-size: 10px;
        padding: 0.45rem 0.5rem;
    }
    .card-title, .page-title {
        text-align: center;
        font-size: 16px;
    }
    .btn {
        font-size: 13px;
        padding: 5px 8px;
    }
    .table-responsive {
        border-radius: 8px;
        overflow-x: auto;
    }

    /* Icons stacked vertically on mobile */
    .text-end {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
    }
    .text-end a,
    .text-end form {
        margin: 0;
    }
}
</style>
@endsection

@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Employee List</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
            </div>
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
                                    <td>
                                        <span class="badge bg-success">{{ ucfirst($employee->status) }}</span>
                                    </td>
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
.table th, .table td {
    vertical-align: middle;
    font-size: 15px;
}

@media (max-width: 575px) {
    .card-title, .page-title {
        text-align: center;
        font-size: 16px;
    }
    .btn {
        font-size: 13px;
        padding: 6px 10px;
    }
    .table th, .table td {
        font-size: 13px;
        padding: 0.45rem 0.5rem;
    }
    .table-responsive {
        border-radius: 8px;
        overflow-x: auto;
    }
/* ✅ Default desktop layout: icons in one row */
.text-end a,
.text-end form {
    display: inline-block;
    margin-left: 5px;
}

/* 📱 Mobile layout: icons stacked vertically */
@media (max-width: 575px) {
    .text-end {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px; /* space between icons */
    }
    .text-end a,
    .text-end form {
        margin: 0;
    }
}


}
</style>
@endsection

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
                <li class="breadcrumb-item active">Dipartments</li>
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
                        <h4 class="card-title">Department List</h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('admin.department.create') }}" class="btn btn-primary">
                            Add Department
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th class="text-start">Name</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($department as $dept)
                                <tr>
                                    <td class="text-start">{{ $dept->name }}</td>
                                    <td class="text-center">{{ ucfirst($dept->status) }}</td> <!-- ✅ Normal text -->
                                    <td class="text-end">
                                        <a href="{{ route('admin.department.edit', $dept->id) }}">
                                            <i class="las la-pen text-secondary font-16"></i>
                                        </a>
                                        <form action="{{ route('admin.department.destroy', $dept->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="button" class="btn-style-none" style="all: unset;" 
                                                onclick="Swal.fire({
                                                    title: 'Delete?',
                                                    text: 'Are you sure you want to delete {{ $dept->name }}?',
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
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No departments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table><!--end /table-->
                </div><!--end /tableresponsive-->          
            </div>
        </div>
    </div>
</div>

<style>
/* Desktop: default font size */
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
}
</style>
@endsection

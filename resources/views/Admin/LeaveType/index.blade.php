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
                <li class="breadcrumb-item active">Leave Types</li>
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
                        <h4 class="card-title">Leave Types List</h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('admin.leavetype.create') }}" class="btn btn-primary">
                            Add
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
                                <th>Total Days</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaveTypes as $type)
                                <tr>
                                    <td class="text-start">{{ $type->name }}</td>
                                    <td class="text-center">{{ $type->total_days_per_year }}</td>
                                      <!-- ✅ Plain text status -->
                                   <td class="status-text text-center">{{ ucfirst($type->status) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.leavetype.edit', $type->id) }}">
                                            <i class="las la-pen text-secondary font-16"></i>
                                        </a>
                                        <form action="{{ route('admin.leavetype.destroy', $type->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="button" class="btn-style-none" style="all: unset;" 
                                                onclick="Swal.fire({
                                                    title: 'Delete?',
                                                    text: 'Are you sure you want to delete {{ $type->name }}?',
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
                                    <td colspan="4" class="text-center">No leave types found.</td>
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
/* Default Desktop View (≥1025px) */
.table th, .table td {
    vertical-align: middle;
    font-size: 13px; /* Desktop font size */
}
.page-title, .card-title {
    font-size: 20px; /* Desktop title size */
}
.btn {
    font-size: 14px;
    padding: 8px 12px;
}

/* Tablet View (768px - 1024px) */
@media (max-width: 1024px) and (min-width: 768px) {
    .table th, .table td {
        font-size: 12px; /* Tablet table font */
    }
    .page-title, .card-title {
        font-size: 18px; /* Tablet title size */
    }
    .btn {
        font-size: 13px;
        padding: 7px 10px;
    }
}

/* Mobile View (<768px) */
@media (max-width: 767px) {
    .table th, .table td {
        font-size: 10px; /* Mobile table font */
        padding: 0.45rem 0.5rem;
    }
    .page-title, .card-title {
        text-align: center;
        font-size: 14px; /* Mobile title size */
    }
    .btn {
        font-size: 12px;
        padding: 5px 8px;
    }
}

</style>
@endsection

@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Leave Types</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active">Leave Types</li>
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
                        <h4 class="card-title">Leave Types List</h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('admin.leavetype.create') }}" class="btn btn-primary">
                            Add Leave
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
                                    <td class="text-center">
                                        @if(strtolower($type->status) === 'active')
                                            <span class="badge bg-success">{{ ucfirst($type->status) }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($type->status) }}</span>
                                        @endif
                                    </td>
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
/* ✅ Responsive font and spacing adjustments */
.table th, .table td {
    vertical-align: middle;
    font-size: 15px;
}

@media (max-width: 1024px) {
    .table th, .table td {
        font-size: 14px;
    }
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
    .badge {
        font-size: 12px;
        padding: 4px 8px;
    }
}
</style>
@endsection

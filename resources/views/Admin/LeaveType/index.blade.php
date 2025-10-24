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
                            Add Leave Type
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Total Days / Year</th>
                                <th>Carry Forward</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaveTypes as $type)
                                <tr>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->total_days_per_year }}</td>
                                    <td>{{ $type->carry_forward ? 'Yes' : 'No' }}</td>
                                    <td>{{ $type->description }}</td>
                                    <td>{{ $type->status === 'active' ? 'Active' : 'Inactive' }}</td>
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
                                    <td colspan="6" class="text-center">No leave types found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table><!--end /table-->
                </div><!--end /tableresponsive-->          
            </div>
        </div>
    </div>
</div>
@endsection

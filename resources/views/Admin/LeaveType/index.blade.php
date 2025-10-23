@extends('Admin.Layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Leave Types</h3>
        <a href="{{ route('admin.leavetype.create') }}" class="btn btn-primary">Add Leave Type</a>
    </div>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Total Days / Year</th>
                <th>Carry Forward</th>
                <th>Description</th>
                <th>Status</th>
                <th width="120">Actions</th>
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
    <!-- Edit Icon -->
    <a href="{{ route('admin.leavetype.edit', $type->id) }}" title="Edit">
        <i class="las la-pen text-secondary font-16"></i>
    </a>

    <!-- Delete Icon (SweetAlert Confirm) -->
    <form action="{{ route('admin.leavetype.destroy', $type->id) }}" method="POST" style="display:inline">
        @csrf
        <!-- @method('DELETE') -->
        <button type="button" style="all: unset;"
            onclick="Swal.fire({
                title: 'Delete?',
                text: 'Are you sure you want to delete {{ $type->name }}?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(255, 73, 194, 0.72)',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => { if(result.isConfirmed){ this.form.submit(); }})"
            title="Delete">
            <i class="las la-trash-alt text-secondary font-16"></i>
        </button>
    </form>
</td>

            </tr>
            @empty 
             
            <tr><td colspan="6">No leave types found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

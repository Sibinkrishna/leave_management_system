@extends('Admin.Layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Holiday List</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
                    <li class="breadcrumb-item active">Holidays</li>
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
                        <h4 class="card-title">Holiday Table</h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('admin.holiday.create') }}" class="btn btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($holidays as $holiday)
                                <tr>
                                    <td>{{ $holiday->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($holiday->date)->format('d M Y') }}</td>
                                    <td>{{ $holiday->description }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.holiday.edit', $holiday->id) }}">
                                            <i class="las la-pen text-secondary font-16"></i>
                                        </a>
                                        <form id="delete-form" action="{{ route('admin.holiday.destroy', $holiday->id) }}" method="post" style="display:inline">
                                            @csrf
                                              <button type="button" style="all: unset;"
            onclick="Swal.fire({
                title: 'Delete?',
                text: 'Are you sure you want to delete {{ $holiday->name }}?',
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
                                <tr>
                                    <td colspan="4" class="text-center">No holidays found.</td>    
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
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
                        <a href="{{ route('admin.employee.create') }}" class="btn btn-primary">Create</a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Customer</th>
                                {{-- <th>Email</th> --}}
                                {{-- <th>Contact No</th> --}}
                                {{-- <th>Join Date</th> --}}
                                {{-- <th>Designation</th> --}}
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . ($employee->avatar ?? 'default.png')) }}" 
                                             alt="{{ $employee->name }}" 
                                             class="rounded-circle thumb-md me-1 d-inline">
                                        {{ $employee->name }}
                                    </td>
                                    {{-- <td>{{ $employee->email }}</td> --}}
                                    {{-- <td>{{ $employee->phone }}</td> --}}
                                    {{-- <td>{{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}</td> --}}
                                    {{-- <td>{{ $employee->designation }}</td> --}}
                                    <td>{{ ucfirst($employee->status) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.employee.show', $employee->id) }}">
                                            <i class="las la-eye text-secondary font-16"></i>
                                        </a>
                                        <a href="{{ route('admin.employee.edit', $employee->id) }}">
                                            <i class="las la-pen text-secondary font-16"></i>
                                        </a>
                                        <form action="{{ route('admin.employee.destroy', $employee->id) }}" 
                                              method="post" style="display:inline">
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
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No employees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table><!-- end table -->
                </div><!-- end table responsive -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

@endsection

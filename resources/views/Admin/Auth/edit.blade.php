@extends('Admin.Layouts.app')

@section('title', 'Edit Admin')
@section('content')
<div class="page-header">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Dashboard</h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">@yield('title')</li>
        </ul>
    </div>
    <div class="page-header-right ms-auto">
        <div class="page-header-right-items">
            <div class="d-flex d-md-none">
                <a href="javascript:void(0)" class="page-header-right-close-toggle">
                    <i class="feather-arrow-left me-2"></i>
                    <span>Back</span>
                </a>
            </div>
            <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                    </div>
                    <div class="avatar avatar-sm">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-md-none d-flex align-items-center">
        </div>
    </div>
</div>
<div class="main-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                                <form method="POST" action="{{ route('admin.update.permissions', $admin->id) }}">
                                    @csrf
                                    <h3 class="mb-3">Assign Permissions to {{ $admin->name }}</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Permission Type</th>
                                                <th class="text-center">View</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">Add</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $modules = ['product', 'customer']; // Add more if needed
                                                $types = ['view', 'edit', 'delete', 'add'];
                                            @endphp

                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td class="text-capitalize">{{ $module }}</td>
                                                    @foreach ($types as $type)
                                                        @php $permName = $type . ' ' . $module; @endphp
                                                        <td class="text-center">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                                    value="{{ $permName }}"
                                                                    id="{{ $permName }}"
                                                                    {{ $admin->hasPermissionTo($permName) ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-primary mt-3">Update Permissions</button>
                                </form>


                    </div>

                </div>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

@extends('Admin.Layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-3">
       <div class="card-header bg-dark text-white">
    <h5 class="mb-0">Apply for Leave</h5>
</div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('employee.leaveapplications.store') }}" method="POST">
                @csrf

                <!-- Row 1: Leave Type, Start Date, End Date -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="leave_type" class="form-label">Leave Type</label>
                        <select name="leave_type_id" id="leave_type" class="form-control" required>
                            <option value="">-- Select Leave Type --</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('leave_type_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Row 2: Subject (full width) -->
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject..." required>
                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Row 2: Reason (full width) -->
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Enter your reason..." required></textarea>
                        @error('reason')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">Apply Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
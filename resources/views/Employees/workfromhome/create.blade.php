@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">WFH records</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Approx</a></li>
                <li class="breadcrumb-item"><a href="#">WFH</a></li>
                <li class="breadcrumb-item active">Records</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Work From Home Entry</h5>
            </div>

            <div class="card-body">
                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('employee.wfh.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        {{-- Entry Date --}}
                        <div class="col-md-4 mb-3">
                            <label for="entry_date" class="form-label">Entry Date</label>
                            <input type="date" name="entry_date" id="entry_date"
                                class="form-control @error('entry_date') is-invalid @enderror"
                                value="{{ old('entry_date') }}" required>
                            @error('entry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Work Duration / Time Slot --}}
                        <div class="col-md-4 mb-3">
                            <label for="work_time" class="form-label">Work Duration (Select Time Slot)</label>
                            <select name="work_time" id="work_time"
                                class="form-select @error('work_time') is-invalid @enderror" required>
                                <option value="">-- Select Time Slot --</option>
                                <option value="10:30 AM">10:30 AM</option>
                                <option value="11:30 AM">11:30 AM</option>
                                <option value="12:30 PM">12:30 PM</option>
                                <option value="1:30 PM">1:30 PM</option>
                                <option value="2:30 PM">2:30 PM</option>
                                <option value="3:30 PM">3:30 PM</option>
                                <option value="4:30 PM">4:30 PM</option>
                                <option value="5:30 PM">5:30 PM</option>
                            </select>
                            @error('work_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Work Status --}}
                        <div class="col-md-4 mb-3">
                            <label for="notes" class="form-label">Work Status</label>
                            <select name="notes" id="notes" 
                                class="form-select @error('notes') is-invalid @enderror" required>
                                <option value="">-- Select Status --</option>
                                <option value="Working">Working</option>
                                <option value="Completed">Completed</option>
                                <option value="Doing">Lunch Time</option>
                            </select>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Task Summary --}}
                        <div class="col-12 mb-3">
                            <label for="task_summary" class="form-label">Task Summary</label>
                            <textarea name="task_summary" id="task_summary" rows="3"
                                class="form-control @error('task_summary') is-invalid @enderror"
                                required>{{ old('task_summary') }}</textarea>
                            @error('task_summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-primary">Submit Work Entry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

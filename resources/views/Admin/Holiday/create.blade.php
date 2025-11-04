@extends('Admin.Layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Add Holiday</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Approx</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.holiday.index') }}">Holidays</a></li>
                    <li class="breadcrumb-item active">Add Holiday</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header bg-light">
                <h4 class="card-title mb-0">Holiday Form</h4>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body pt-0">
                <form action="{{ route('admin.holiday.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Holiday Name -->
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Holiday Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ old('name') }}" placeholder="Enter holiday name" required>
                        </div>

                        <!-- Date -->
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                   value="{{ old('date') }}" required>
                        </div>

                        <!-- Day (Auto-filled) -->
                        <div class="col-md-4 mb-3">
                            <label for="day" class="form-label">Day</label>
                            <input type="text" class="form-control" id="day" name="day"
                                   value="{{ old('day') }}" placeholder="Auto-filled" readonly>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea class="form-control" id="description" name="description"
                                      placeholder="Enter holiday description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger ms-2">Cancel</button>
                        <a href="{{ route('admin.holiday.index') }}" class="btn btn-secondary ms-2">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for auto-filling Day --}}
<script>
    document.getElementById('date').addEventListener('change', function() {
        const dateValue = this.value;
        if (dateValue) {
            const day = new Date(dateValue).toLocaleDateString('en-US', { weekday: 'long' });
            document.getElementById('day').value = day;
        } else {
            document.getElementById('day').value = '';
        }
    });
</script>
@endsection

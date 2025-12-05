@extends('Admin.Layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow p-4 rounded-4">

        <h4 class="fw-bold mb-3">Edit Profile</h4>

        <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- Profile Photo -->
                <div class="col-md-3 text-center">
                    <img id="avatarPreview"
                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://via.placeholder.com/120' }}"
                         class="rounded-circle border"
                         style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                    
                    <div class="mt-2">
                        <label class="fw-bold">Change Photo</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="form-control"
                               onchange="previewAvatar(event)">
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="col-md-9">

                    <div class="row">

                        <!-- Full Name -->
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="form-control">
                        </div>

                        <!-- Contact -->
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Contact</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="form-control">
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Designation</label>
                            <input type="text" name="designation" value="{{ old('designation', $user->designation) }}" 
                                   class="form-control">
                        </div>

                    </div>

                </div>
            </div>

            <!-- Submit -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary px-4">Update</button>
            </div>

        </form>
    </div>
</div>

<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('avatarPreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection

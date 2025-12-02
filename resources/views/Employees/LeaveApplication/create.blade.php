@extends('Admin.Layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-3">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3">
            <h5 class="mb-0 fs-6 fs-md-5">Apply For Leave</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

<form action="{{ route('employee.leaveapplications.store') }}" 
      method="POST" 
      enctype="multipart/form-data">
                @csrf

                <!-- ⭐ Row 1: Leave Type, Start Date, End Date, Day Type -->
                <div class="row mb-3">

                    <div class="col-md-3">
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

                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Day Type</label>
                        <select name="day_type" id="day_type" class="form-control" required>
                            <option value="full">Full Day</option>
                            <option value="half_fn">Half Day (FN)</option>
                            <option value="half_an">Half Day (AN)</option>
                        </select>
                    </div>

                </div>

                <!-- ⭐ Row 2: Subject -->
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject..." required>
                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- ⭐ Row 3: Reason -->
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Enter your reason..." required></textarea>
                        @error('reason')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- ⭐ Row 4: Medical Certificate Upload (Conditional) -->
               <div class="row mb-3 d-none" id="medical_certificate_row">
                 <div class="col-12">
                      <label class="form-label">Medical Certificate (PDF/JPG)</label>
                      <input type="file" name="medical_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                      @error('medical_certificate')
                         <small class="text-danger">{{ $message }}</small>
                      @enderror
                 </div>
               </div>
<div class="text-end">
    <button type="button" id="apply_leave_btn" class="btn btn-success px-4">
        Apply Leave
    </button>
</div>
{{-- popopp --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const applyBtn = document.getElementById("apply_leave_btn");

    const hrNumber = "{{ config('services.hr.whatsapp') }}";

    function getField(id) {
        let el = document.getElementById(id);
        return el ? el.value.trim() : "";
    }

    applyBtn.addEventListener("click", function () {

        // Validate required fields
        if (!getField('leave_type')) { return alert("Please select Leave Type"); }
        if (!getField('start_date')) { return alert("Please select Start Date"); }
        if (!getField('end_date'))   { return alert("Please select End Date"); }
        if (!getField('subject'))    { return alert("Please enter Subject"); }

        // Ask user if they want to send WhatsApp
        Swal.fire({
            title: "Leave Submitted!",
            text: "Do you want to send this leave application via WhatsApp?",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Yes, Send WhatsApp",
            cancelButtonText: "No, Only Submit",
            confirmButtonColor: "#25D366",
        }).then((result) => {

            // If YES → send WhatsApp + submit form
            if (result.isConfirmed) {

                const leaveTypeText = document.getElementById("leave_type").selectedOptions[0].text;
                const dayTypeText = document.getElementById("day_type").selectedOptions[0].text;

                const message = [
                    "*Leave Application*",
                    `*Employee:* {{ Auth::user()->name }}`,
                    `*Leave Type:* ${leaveTypeText}`,
                    `*Start Date:* ${getField('start_date')}`,
                    `*End Date:* ${getField('end_date')}`,
                    `*Day Type:* ${dayTypeText}`,
                    `*Subject:* ${getField('subject')}`,
                    `*Reason:* ${getField('reason') || '(No reason)'}`,
                    "",
                    "_Sent from Leave Management System_"
                ].join("\n");

                const encoded = encodeURIComponent(message);

                const waURL = `https://wa.me/${hrNumber}?text=${encoded}`;

                window.open(waURL, "_blank");

                // Submit form after WhatsApp link opens
                setTimeout(() => {
                    document.querySelector("form").submit();
                }, 500);

            } else {
                // If NO → submit normally
                document.querySelector("form").submit();
            }

        });

    });

});
</script>







<script>
document.addEventListener("DOMContentLoaded", function () {

    function checkMedicalCertificate() {
        let leaveType = document.getElementById("leave_type").value;
        let start = document.getElementById("start_date").value;
        let end = document.getElementById("end_date").value;

        if (!start || !end) return;

        let startDate = new Date(start);
        let endDate = new Date(end);
        let dayDiff = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1;

        // Medical Leave ID (change if needed)
        let medicalLeaveID = "{{ $leaveTypes->where('name', 'Medical Leave')->first()->id ?? '' }}";

        if (leaveType == medicalLeaveID && dayDiff > 3) {
            document.getElementById("medical_certificate_row").classList.remove("d-none");
        } else {
            document.getElementById("medical_certificate_row").classList.add("d-none");
        }
    }

    document.getElementById("leave_type").addEventListener("change", checkMedicalCertificate);
    document.getElementById("start_date").addEventListener("change", checkMedicalCertificate);
    document.getElementById("end_date").addEventListener("change", checkMedicalCertificate);
});

</script>


            </form>
        </div>
    </div>
</div>
@endsection
<!-- ---------- WhatsApp script ---------- -->

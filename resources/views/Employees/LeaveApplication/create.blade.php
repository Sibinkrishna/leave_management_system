
You said:
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
                    <button type="submit" class="btn btn-success px-4">Apply Leave</button>
                </div>
                 
  

<div class="d-flex justify-content-start mt-4">
    <button type="button" id="send_whatsapp_btn" class="btn btn-success px-4 me-2">Send via WhatsApp</button>
    {{-- <a id="direct_whatsapp_link" href="javascript:void(0);" class="btn btn-success px-4">Send via WhatsApp</a>
</div> --}}


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

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sendBtn = document.getElementById('send_whatsapp_btn');

    const hrNumber = "{{ config('services.hr.whatsapp') }}";

    if (!hrNumber || hrNumber.trim() === "") {
        sendBtn.disabled = true;
        sendBtn.title = "HR WhatsApp number not configured";
        return;
    }

    function getField(id) {
        let el = document.getElementById(id);
        return el ? el.value.trim() : "";
    }

    function validateFields() {
        if (!getField('leave_type')) {
            alert("Please select Leave Type.");
            return false;
        }
        if (!getField('start_date')) {
            alert("Please select Start Date.");
            return false;
        }
        if (!getField('end_date')) {
            alert("Please select End Date.");
            return false;
        }
        if (!getField('subject')) {
            alert("Please enter Subject.");
            return false;
        }
        return true;
    }

    sendBtn.addEventListener("click", function () {

        if (!validateFields()) return;

        const leaveTypeSelect = document.getElementById('leave_type');
        const dayTypeSelect = document.getElementById('day_type');

        const employeeName = "{{ Auth::user()->name ?? 'Employee' }}";
        const leaveType = leaveTypeSelect.selectedOptions[0].text;
        const start = getField('start_date');
        const end = getField('end_date');
        const dayType = dayTypeSelect.selectedOptions[0].text;
        const subject = getField('subject');
        const reason = getField('reason') || "(No reason provided)";

        // ✅ Use template literals correctly
        const message = `*Leave Application*
*Employee:* ${employeeName}
*Leave Type:* ${leaveType}
*Start Date:* ${start}
*End Date:* ${end}
*Day Type:* ${dayType}
*Subject:* ${subject}
*Reason:* ${reason}

_Sent from the Leave Management System_`;

        const encodedMessage = encodeURIComponent(message);

        // ✅ Correct WhatsApp URL
        const waUrl = `https://wa.me/${hrNumber}?text=${encodedMessage}`;

        window.open(waUrl, "_blank");
    });

});
</script>




            </form>
        </div>
    </div>
</div>
@endsection
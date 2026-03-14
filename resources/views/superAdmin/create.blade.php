<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Super Admin | CorpPanel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* MAIN CONTENT */

        #main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: 0.3s;
        }



        /* CARDS */

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.08);
        }

        /* CHART */

        .chart-container {
            position: relative;
            height: 280px;
        }

        /* MOBILE */

        @media(max-width:992px) {


            #main-content {
                margin-left: 0;
                width: 100%;
            }

        }

        #pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
    </style>

</head>

<body>


    <!-- SIDEBAR -->
    @include('layouts.superadmin.sidebar')


    <!-- MAIN CONTENT -->

    <div id="main-content">


        <!-- HEADER -->

        @include('layouts.superadmin.header')


        <!-- CONTENT -->

        <div class="container-fluid p-4">

            <div class="card stat-card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="bi bi-person-plus-fill text-primary fs-4 me-2"></i>
                    <h6 class="mb-0 fw-bold">Register New Employee</h6>
                </div>

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-white fw-bold text-primary">
                        Personal Information
                    </div>

                    <div class="card-body p-4">

                        <form id="hrForm" action="{{ route('employee.store') }}" method="POST"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="row">

                                <!-- Profile Image -->
                                <div class="col-md-3 text-center">

                                    <label class="form-label fw-bold text-muted">
                                        Profile Image <span class="text-danger">*</span>
                                    </label>

                                    <div class="mb-3">
                                        <img id="imagePreview" src="\upload_images\download.png"
                                            class="rounded-circle border shadow" width="120" height="120"
                                            style="object-fit:cover;">
                                    </div>

                                    <input type="file" name="image" id="imageUpload" class="form-control"
                                        accept="image/*">

                                </div>

                                <!-- Form Fields -->
                                <div class="col-md-9">

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">
                                                Full Name <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" class="form-control bg-light border-0"
                                                placeholder="e.g. Robert Fox" name="name" pattern="[A-Za-z\s]+"
                                                oninput="this.value = this.value.replace(/[^A-Za-z\s]/g,'')" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">
                                                Email <span class="text-danger">*</span>
                                            </label>

                                            <input type="email" class="form-control bg-light border-0"
                                                placeholder="robert@company.com" name="email" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">
                                                Phone <span class="text-danger">*</span>
                                            </label>

                                            <input type="tel" class="form-control bg-light border-0"
                                                placeholder="Enter 10 digit phone" name="phone" maxlength="10"
                                                pattern="[6-9][0-9]{9}"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^([0-5])/, '').slice(0,10)">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">
                                                Gender <span class="text-danger">*</span>
                                            </label>

                                            <div class="d-flex gap-4 mt-2">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="male" value="Male" required>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="female" value="Female">
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="other" value="Other">
                                                    <label class="form-check-label" for="other">Other</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">
                                                Date of Birth <span class="text-danger">*</span>
                                            </label>

                                            <input type="date" class="form-control bg-light border-0"
                                                name="date_of_birth" required>
                                        </div>

                                    </div>

                                </div>

                            </div>
                    </div>
                </div>
                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-white fw-bold text-primary">
                        Company Information
                    </div>

                    <div class="card-body p-4">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Company Name <span class="text-danger">*</span>
                                </label>

                                <select class="form-select bg-light border-0" name="company" required>
                                    <option value="">Choose company</option>

                                    @foreach ($compay as $compay)
                                        <option value="{{ $compay->company_code }}">
                                            {{ $compay->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Department <span class="text-danger">*</span>
                                </label>

                                <select class="form-select bg-light border-0" name="department" id="department"
                                    required>

                                    <option value="">Choose Department</option>

                                    @foreach ($department as $dept)
                                        <option value="{{ $dept->id }}">
                                            {{ $dept->department_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6" id="subDepartmentDiv" style="display:none;">
                                <label class="form-label small fw-bold text-muted">
                                    Subdepartment
                                </label>

                                <select class="form-select bg-light border-0" name="subdepartment"
                                    id="subdepartment">

                                    <option value="">Choose Subdepartment</option>

                                </select>
                            </div>

                            <div class="col-md-6" id="designationDiv" style="display:none;">
                                <label class="form-label small fw-bold text-muted">
                                    Designation
                                </label>

                                <select class="form-select bg-light border-0" name="designation" id="designation">

                                    <option value="">Choose Designation</option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Joining Date <span class="text-danger">*</span>
                                </label>

                                <input type="date" class="form-control bg-light border-0" name="joning_date">
                            </div>


                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Employment Type
                                </label>

                                <select class="form-select bg-light border-0" name="employment_type">
                                    <option value="">Select Type</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Contract">Contract</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Salary
                                </label>

                                <input type="text" class="form-control bg-light border-0" name="salary"
                                    placeholder="Enter employee salary">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Work Location
                                </label>

                                <input type="text" class="form-control bg-light border-0" name="work_location"
                                    placeholder="Office Location">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Experience
                                </label>

                                <input type="number" class="form-control bg-light border-0" name="experience"
                                    placeholder="Enter experience in years" min="0">
                            </div>

                        </div>

                    </div>

                </div>
                <div class="card shadow-sm mb-4" id="educationCard" style="display:none;">

                    <div class="card-header bg-white fw-bold text-primary">
                        Educational Information
                    </div>

                    <div class="card-body p-4">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    College Name
                                </label>

                                <input type="text" class="form-control bg-light border-0" name="college_name"
                                    placeholder="Enter college name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Course
                                </label>

                                <input type="text" class="form-control bg-light border-0" name="course"
                                    placeholder="e.g BCA / B.Tech / MCA">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Last Year Marksheet
                                </label>

                                <input type="file" class="form-control bg-light border-0" name="marksheet"
                                    accept=".jpg,.jpeg,.png,.pdf">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Internship Duration
                                </label>

                                <select class="form-select bg-light border-0" name="internship_duration">
                                    <option value="">Select Duration</option>
                                    <option value="1 Month">1 Month</option>
                                    <option value="3 Months">3 Months</option>
                                    <option value="6 Months">6 Months</option>
                                    <option value="12 Months">12 Months</option>
                                </select>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-white fw-bold text-primary">
                        Documentation
                    </div>

                    <div class="card-body p-4">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    ID Proof Type
                                </label>

                                <select class="form-select bg-light border-0" name="id_proof_type">
                                    <option value="">Select ID Proof</option>
                                    <option value="Aadhar Card">Aadhar Card</option>
                                    <option value="PAN Card">PAN Card</option>
                                    <option value="Voter ID">Voter ID</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Driving License">Driving License</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    ID Proof Number
                                </label>

                                <input type="text" class="form-control bg-light border-0" name="id_proof_number"
                                    placeholder="Enter ID Proof Number">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Upload ID Proof
                                </label>

                                <input type="file" class="form-control bg-light border-0" name="id_proof_file"
                                    accept=".jpg,.jpeg,.png,.pdf">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Address Proof Type
                                </label>

                                <select class="form-select bg-light border-0" name="address_proof_type">
                                    <option value="">Select Address Proof</option>
                                    <option value="Aadhar Card">Aadhar Card</option>
                                    <option value="Electricity Bill">Electricity Bill</option>
                                    <option value="Bank Passbook">Bank Passbook</option>
                                    <option value="Rent Agreement">Rent Agreement</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Upload Address Proof
                                </label>

                                <input type="file" class="form-control bg-light border-0"
                                    name="address_proof_file" accept=".jpg,.jpeg,.png,.pdf">
                            </div>

                        </div>

                    </div>

                </div>

                <div class="card shadow-sm">

                    <div class="card-header bg-white fw-bold text-primary">
                        Address Information
                    </div>

                    <div class="card-body p-4">

                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">
                                    Address <span class="text-danger">*</span>
                                </label>

                                <textarea class="form-control bg-light border-0" name="address" rows="2"
                                    placeholder="Street, Apartment, Landmark"></textarea>
                            </div>

                            <div class="col-md-4">

                                <label class="form-label small fw-bold text-muted">
                                    State <span class="text-danger">*</span>
                                </label>

                                <select class="form-select bg-light border-0" id="state_id" name="state" required>

                                    <option selected disabled>Select State</option>

                                    @foreach ($state as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label small fw-bold text-muted">
                                    District <span class="text-danger">*</span>
                                </label>

                                <select class="form-select bg-light border-0" id="district_id" name="distric"
                                    required>

                                    <option selected disabled>Select District</option>

                                </select>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label small fw-bold text-muted">
                                    City
                                </label>

                                <input type="text" class="form-control bg-light border-0" placeholder="City"
                                    name="city">

                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">
                                    Pincode <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control bg-light border-0" name="pincode"
                                    placeholder="Enter 6 digit pincode" maxlength="6" pattern="[0-9]{6}"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,6)" required>
                            </div>

                        </div>

                        <div class="mt-4 text-end">

                            <button type="reset" class="btn btn-outline-secondary">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i>
                                Save
                            </button>

                        </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>
    <div id="pageLoader">
        <div class="spinner-border text-light" role="status"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $('#state_id').change(function() {

            var state_id = $(this).val();

            $.ajax({
                url: '/superadmin/get-districts/' + state_id,
                type: 'GET',

                success: function(data) {

                    $('#district_id').html('<option value="">Select District</option>');

                    $.each(data, function(key, value) {

                        $('#district_id').append('<option value="' + value.id + '">' + value
                            .name + '</option>');

                    });

                }

            });

        });
    </script>
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(e) {

            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    preview.src = event.target.result;
                }

                reader.readAsDataURL(file);
            }

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            // When Department changes
            $('#department').change(function() {
                var deptId = $(this).val();

                // Departments where Designation should be hidden (HR = 6, Project Manager = 8 example IDs)
                var hideDesignation = [6, 8];

                if (deptId == "") {
                    $('#subDepartmentDiv, #designationDiv').hide();
                } else {
                    // Show Subdepartment
                    $('#subDepartmentDiv').show();

                    // AJAX to get Subdepartments
                    $.ajax({
                        url: '/superadmin/get-subdepartments/' + deptId,
                        type: 'GET',
                        success: function(response) {
                            var options = '<option value="">Choose Subdepartment</option>';
                            response.forEach(function(sub) {
                                options += '<option value="' + sub.id + '">' + sub
                                    .subdepartment_name + '</option>';
                            });
                            $('#subdepartment').html(options);
                        }
                    });

                    // Hide designation if department is HR or Project Manager
                    if (hideDesignation.includes(parseInt(deptId))) {
                        $('#designationDiv').hide();
                    } else {
                        $('#designationDiv').show();
                        $('#designation').html(
                            '<option value="">Choose Designation</option>'
                        ); // Will populate after Subdepartment select
                    }
                }
            });

            // When Subdepartment changes
            $('#subdepartment').change(function() {
                var subId = $(this).val();
                if (subId != "") {
                    // AJAX to get Designations for selected Subdepartment
                    $.ajax({
                        url: '/superadmin/get-designations/' + subId,
                        type: 'GET',
                        success: function(response) {
                            var options = '<option value="">Choose Designation</option>';
                            response.forEach(function(des) {
                                options += '<option value="' + des.code + '">' + des
                                    .name + '</option>';
                            });
                            $('#designation').html(options);
                        }
                    });
                } else {
                    $('#designation').html('<option value="">Choose Designation</option>');
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('select[name="designation"]').change(function() {

                var type = $(this).val();

                if (type === "intern") {
                    $('#educationCard').slideDown();
                } else {
                    $('#educationCard').slideUp();
                }

            });

        });
    </script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#hrForm').submit(function(e) {

                e.preventDefault();

                let name = $('input[name="name"]').val().trim();
                let email = $('input[name="email"]').val().trim();
                let phone = $('input[name="phone"]').val().trim();
                let gender = $('input[name="gender"]:checked').val();
                let dob = $('input[name="date_of_birth"]').val();
                let company = $('select[name="company"]').val();
                let department = $('#department').val();
                let state = $('#state_id').val();
                let district = $('#district_id').val();
                let address = $('textarea[name="address"]').val().trim();
                let pincode = $('input[name="pincode"]').val().trim();

                if (name === "") {
                    Toast.fire({
                        icon: 'error',
                        title: 'Full Name is required'
                    });
                    return;
                }

                if (email === "") {
                    Toast.fire({
                        icon: 'error',
                        title: 'Email is required'
                    });
                    return;
                }

                if (phone.length !== 10) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Enter valid 10 digit phone'
                    });
                    return;
                }

                if (!gender) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Please select gender'
                    });
                    return;
                }

                if (dob === "") {
                    Toast.fire({
                        icon: 'error',
                        title: 'Date of birth required'
                    });
                    return;
                }

                if (company === "") {
                    Toast.fire({
                        icon: 'error',
                        title: 'Select company'
                    });
                    return;
                }

                if (department === "") {
                    Toast.fire({
                        icon: 'error',
                        title: 'Select department'
                    });
                    return;
                }

                if (state === null) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Select state'
                    });
                    return;
                }

                if (district === null) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Select district'
                    });
                    return;
                }

                if (address === "") {
                    Toast.fire({
                        icon: 'error',
                        title: 'Address required'
                    });
                    return;
                }

                if (pincode.length !== 6) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Enter valid pincode'
                    });
                    return;
                }

                // Loader show
                $('#pageLoader').show();

                this.submit();
            });

        });
    </script>
</body>

</html>

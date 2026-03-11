<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Employee | CorpPanel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        #main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, .08);
        }

        #pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
    </style>

</head>

<body>

    @include('layouts.superadmin.sidebar')


    <!-- MAIN CONTENT -->

    <div id="main-content">


        <!-- HEADER -->

        @include('layouts.superadmin.header')


        <div class="container-fluid p-4">

            <div class="card stat-card">

                <div class="card-header bg-white fw-bold">
                    Edit Employee
                </div>

                <div class="card-body p-4">

                    <form id="hrForm" action="{{ route('employee.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- IMAGE -->

                            <div class="col-md-3 text-center">

                                <label class="form-label fw-bold text-muted">
                                    Profile Image
                                </label>

                                <div class="mb-3">

                                    <img id="imagePreview"
                                        src="{{ $user->image ? asset('upload_images/' . $user->image) : asset('upload_images/download.png') }}"
                                        class="rounded-circle border shadow" width="120" height="120"
                                        style="object-fit:cover">

                                </div>

                                <input type="file" name="image" id="imageUpload" class="form-control">

                            </div>


                            <!-- PERSONAL DETAILS -->

                            <div class="col-md-9">

                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label class="form-label">Full Name</label>

                                        <input type="text" class="form-control bg-light border-0" name="name"
                                            value="{{ $user->name }}">

                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label">Email</label>

                                        <input type="email" class="form-control bg-light border-0" name="email"
                                            value="{{ $user->email }}">

                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label">Phone</label>

                                        <input type="tel" class="form-control bg-light border-0" name="phone"
                                            value="{{ $user->phone }}">

                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label">Gender</label>

                                        <div>

                                            <input type="radio" name="gender" value="Male"
                                                {{ $user->gender == 'Male' ? 'checked' : '' }}> Male

                                            <input type="radio" name="gender" value="Female"
                                                {{ $user->gender == 'Female' ? 'checked' : '' }}> Female

                                            <input type="radio" name="gender" value="Other"
                                                {{ $user->gender == 'Other' ? 'checked' : '' }}> Other

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label">Date of Birth</label>

                                        <input type="date" class="form-control bg-light border-0"
                                            name="date_of_birth"
                                            value="{{ \Carbon\Carbon::parse($user->dob)->format('Y-m-d') }}">

                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <!-- COMPANY INFO -->

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label">Company</label>

                                <select class="form-select bg-light border-0" name="company">

                                    @foreach ($company as $compay)
                                        <option value="{{ $compay->company_code }}"
                                            {{ $user->company_name == $compay->company_code ? 'selected' : '' }}>

                                            {{ $compay->name }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">Department</label>

                                <select class="form-select bg-light border-0" disabled>

                                    @foreach ($department as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ $user->department == $dept->id ? 'selected' : '' }}>

                                            {{ $dept->department_name }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">Subdepartment</label>

                                <input type="text" class="form-control bg-light border-0"
                                    value="{{ $subdepartment->subdepartment_name }}" disabled>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">Designation</label>

                                <input type="text" class="form-control bg-light border-0"
                                    value="{{ $user->designation }}" disabled>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">Joining Date</label>

                                <input type="date" class="form-control bg-light border-0" name="joning_date"
                                    value="{{ \Carbon\Carbon::parse($user->joining_date)->format('Y-m-d') }}">

                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Employment Type
                                </label>

                                <select class="form-select bg-light border-0" name="employment_type">
                                    <option value="">Select Type</option>

                                    <option value="Full Time"
                                        {{ $user->employee_type == 'Full Time' ? 'selected' : '' }}>
                                        Full Time
                                    </option>

                                    <option value="Part Time"
                                        {{ $user->employee_type == 'Part Time' ? 'selected' : '' }}>
                                        Part Time
                                    </option>

                                    <option value="Contract"
                                        {{ $user->employee_type == 'Contract' ? 'selected' : '' }}>
                                        Contract
                                    </option>

                                </select>
                            </div>

                            <div class="col-md-6">

                                <label class="form-label">Salary</label>

                                <input type="text" class="form-control bg-light border-0" name="salary"
                                    value="{{ $user->salary }}">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">Work Location</label>

                                <input type="text" class="form-control bg-light border-0" name="work_location"
                                    value="{{ $user->work_location }}">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">Experience</label>

                                <input type="number" class="form-control bg-light border-0" name="experience"
                                    value="{{ $user->experience }}">

                            </div>

                        </div>

                        <hr>

                        <!-- ADDRESS -->

                        <div class="row g-3">

                            <div class="col-12">

                                <label class="form-label">Address</label>

                                <textarea class="form-control bg-light border-0" name="address">{{ $user->address }}</textarea>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">State</label>

                                <select class="form-select bg-light border-0" name="state">

                                    @foreach ($state as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $user->state == $s->id ? 'selected' : '' }}>

                                            {{ $s->name }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">District</label>

                                <select class="form-select bg-light border-0" name="distric">

                                    @foreach ($districs as $d)
                                        <option value="{{ $d->id }}"
                                            {{ $user->distric == $d->id ? 'selected' : '' }}>

                                            {{ $d->name }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">City</label>

                                <input type="text" class="form-control bg-light border-0" name="city"
                                    value="{{ $user->city }}">

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">Pincode</label>

                                <input type="text" class="form-control bg-light border-0" name="pincode"
                                    value="{{ $user->pincode }}">

                            </div>

                        </div>

                        <div class="mt-4 text-end">

                            <button type="submit" class="btn btn-primary">
                                Update Employee
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <div id="pageLoader">
        <div class="spinner-border text-light"></div>
    </div>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(e) {

            let file = e.target.files[0];
            let preview = document.getElementById('imagePreview');

            if (file) {

                let reader = new FileReader();

                reader.onload = function(event) {
                    preview.src = event.target.result;
                }

                reader.readAsDataURL(file);

            }

        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let hash = window.location.hash;

            if (hash === "#employeesMenu") {

                let menu = document.getElementById("employeesMenu");

                if (menu) {
                    new bootstrap.Collapse(menu, {
                        toggle: true
                    });
                }

            }

        });
    </script>

</body>

</html>

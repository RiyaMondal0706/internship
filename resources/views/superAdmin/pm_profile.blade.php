<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Super Admin | CorpPanel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background: #f5f7fb;
        }

        #main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: .3s;
        }

        .profile-card {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .section-card {
            border-radius: 10px;
            border: 1px solid #eee;
            background: #fff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .03);
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .5px;
            color: #555;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .info-label {
            font-size: 12px;
            color: #888;
        }

        .info-value {
            font-weight: 500;
            font-size: 15px;
        }

        .profile-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
        }
    </style>

</head>

<body>

    @include('layouts.superadmin.sidebar')

    <div id="main-content">

        @include('layouts.superadmin.header')

        @php
            $dep = DB::table('departments')->where('id', $tm->department)->first();
        @endphp

        <div class="container-fluid py-4">

            <div class="row">

                <!-- LEFT PROFILE PANEL -->

                <div class="col-lg-4 mb-4">

                    <div class="card profile-card text-center p-4">

                        <div class="position-relative d-inline-block mb-3">

                            <img src="{{ $tm->image ? asset('upload_images/' . $tm->image) : asset('upload_images/download.png') }}"
                                class="rounded-circle border border-2 border-white shadow" width="200"
                                height="200">

                        </div>

                        <h4 class="fw-bold mb-1">{{ $tm->name }}</h4>

                        <p class="text-muted small mb-3">
                            {{ strtoupper($dep->department_name ?? '') }} • ID: #{{ $tm->employee_code }}
                        </p>

                        <div class="d-grid gap-2">

                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $tm->email }}&su=Hello&body=Dear {{ $tm->name }}"
                                target="_blank" class="btn btn-primary">

                                <i class="bi bi-envelope me-2"></i>Send Email
                            </a>

                            <a href="{{ route('pm.edit', $tm->id) }}" class="btn btn-outline-dark">

                                <i class="bi bi-pencil me-2"></i>Edit Account
                            </a>

                        </div>

                        <hr>

                        <div class="text-start">

                            <h6 class="section-title">Quick Actions</h6>

                            <div class="list-group">

                                <a href="#" class="list-group-item list-group-item-action text-danger">

                                    <i class="bi bi-slash-circle me-2"></i>Deactivate

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT SIDE INFORMATION -->

                <div class="col-lg-8">

                    <!-- PERSONAL INFO -->

                    <div class="section-card p-4 mb-4">

                        <h6 class="section-title">Personal Information</h6>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Gender</div>
                                <div class="info-value">{{ $tm->gender }}</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Date of Birth</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($tm->dob)->format('d F Y') }}
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Experience</div>
                                <div class="info-value">{{ $tm->experience }} Year</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Pincode</div>
                                <div class="info-value">{{ $tm->pincode }}</div>
                            </div>

                        </div>

                    </div>

                    <!-- COMPANY INFO -->

                    <div class="section-card p-4 mb-4">

                        <h6 class="section-title">Company Information</h6>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Company</div>
                                <div class="info-value">{{ $tm->company_name }}</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Department</div>
                                <div class="info-value">{{ $dep->department_name ?? '' }}</div>
                            </div>
                            @php
                                $dep = DB::table('subdepartment')->where('id', $tm->subdepartment)->first();
                            @endphp

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Sub Department</div>
                                <div class="info-value">{{ $dep->subdepartment_name }}</div>
                            </div>



                            <div class="col-md-4 mb-3">
                                <div class="info-label">Employee Type</div>
                                <div class="info-value">{{ $tm->employee_type }}</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Work Location</div>
                                <div class="info-value">{{ $tm->work_location }}</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="info-label">Salary</div>
                                <div class="info-value">₹ {{ $tm->salary }}</div>
                            </div>

                        </div>

                    </div>

                    <!-- DOCUMENTS -->

                    <div class="section-card p-4">

                        <h6 class="section-title">Documents</h6>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <div class="info-label">ID Proof Type</div>
                                <div class="info-value">{{ $tm->id_proof_type }}</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="info-label">ID Proof Number</div>
                                <div class="info-value">{{ $tm->id_proof_number }}</div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

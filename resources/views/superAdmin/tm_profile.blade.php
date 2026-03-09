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
        #main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: 0.3s;
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

        @php
            $dep = DB::table('departments')->where('id', $tm->department)->first();
        @endphp

        <div class="card-body p-0">
            <div class="row g-0">

                <!-- LEFT PROFILE PANEL -->

                <div class="col-lg-4 bg-light border-end p-5 text-center">

                    <div class="mb-4 position-relative d-inline-block">

                        <img src="{{ $tm->image ? asset('images/teamleader/' . $tm->image) : asset('upload_images/download.png') }}"
                            class="rounded-circle shadow-sm border border-4 border-white" width="140" alt="profile">

                        <span
                            class="position-absolute bottom-0 end-0 bg-success border border-3 border-white rounded-circle"
                            style="width:22px;height:22px;" title="Online"></span>

                    </div>

                    <h4 class="fw-bold text-dark mb-1">{{ $tm->name }}</h4>

                    <p class="text-muted small mb-4">
                        {{ strtoupper($dep->department_name ?? '') }} • ID: #tm-9921
                    </p>

                    <div class="d-grid gap-2">

                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $tm->email }}&su=Hello&body=Dear {{ $tm->name }},"
                            target="_blank" class="btn btn-primary shadow-sm">

                            <i class="bi bi-envelope me-2"></i>Send Email

                        </a>

                        <a href="{{ route('tm.edit', $tm->id) }}" class="btn btn-outline-dark">

                            <i class="bi bi-pencil me-2"></i>Edit Account

                        </a>

                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="text-start">

                        <h6 class="text-uppercase small fw-bold text-muted mb-3">
                            Quick Actions
                        </h6>

                        <div class="list-group list-group-flush rounded-3 border">

                            <a href="#" class="list-group-item list-group-item-action small text-danger">

                                <i class="bi bi-slash-circle me-2"></i> Deactivate

                            </a>

                        </div>

                    </div>

                </div>


                <!-- RIGHT INFORMATION PANEL -->

                <div class="col-lg-8 p-5">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">General Information</h5>

                    </div>

                    <div class="row g-4">

                        <div class="col-sm-6">

                            <div class="p-3 border rounded-3 bg-white shadow-sm">

                                <label class="d-block text-muted small mb-1">
                                    Email Address
                                </label>

                                <div class="fw-bold text-dark">
                                    {{ $tm->email }}
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6">

                            <div class="p-3 border rounded-3 bg-white shadow-sm">

                                <label class="d-block text-muted small mb-1">
                                    Mobile Number
                                </label>

                                <div class="fw-bold text-dark">
                                    +91 {{ $tm->phone }}
                                </div>

                            </div>

                        </div>


                        <div class="col-sm-6">

                            <div class="p-3 border rounded-3 bg-white shadow-sm">

                                <label class="d-block text-muted small mb-1">
                                    Department
                                </label>

                                <div class="fw-bold text-dark">
                                    {{ strtoupper($dep->department_name ?? '') }}
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-6">

                            <div class="p-3 border rounded-3 bg-white shadow-sm">

                                <label class="d-block text-muted small mb-1">
                                    Joining Date
                                </label>

                                <div class="fw-bold text-dark">

                                    {{ \Carbon\Carbon::parse($tm->joining)->format('d F Y') }}

                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="p-4 border rounded-3 bg-light-subtle">

                                <h6 class="fw-bold mb-3 small text-uppercase">
                                    Address & Location
                                </h6>

                                <div class="row">

                                    <div class="col-md-6 mb-3">

                                        <label class="text-muted small d-block">
                                            Street Address
                                        </label>

                                        <span class="fw-medium">
                                            {{ $tm->address }}
                                        </span>

                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label class="text-muted small d-block">
                                            City
                                        </label>

                                        <span class="fw-medium">
                                            {{ $tm->city }}
                                        </span>

                                    </div>

                                    @php
                                        $state = DB::table('states')->where('id', $tm->state)->first();
                                    @endphp

                                    <div class="col-md-6 mb-3">

                                        <label class="text-muted small d-block">
                                            State
                                        </label>

                                        <span class="fw-medium">
                                            {{ $state->name ?? '' }}
                                        </span>

                                    </div>

                                    @php
                                        $districts = DB::table('districts')->where('id', $tm->district)->first();
                                    @endphp

                                    <div class="col-md-6 mb-3">

                                        <label class="text-muted small d-block">
                                            District
                                        </label>

                                        <span class="fw-medium">
                                            {{ $districts->name ?? '' }}
                                        </span>

                                    </div>

                                </div>

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

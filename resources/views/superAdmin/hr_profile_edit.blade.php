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
                    <i class="bi bi-pencil-square text-warning fs-4 me-2"></i>
                    <h6 class="mb-0 fw-bold">Edit HR Manager</h6>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('hr.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <!-- Profile Image -->
                            <div class="col-md-3 text-center">
                                <label class="form-label fw-bold text-muted">
                                    Profile Image <span class="text-danger">*</span>
                                </label>

                                <div class="mb-3">
                                    <img id="imagePreview"
                                        src="{{ $user->image ? asset('images/hr/' . $user->image) : asset('upload_images/download.png') }}"
                                        class="rounded-circle border shadow" width="120" height="120"
                                        style="object-fit:cover;">
                                </div>

                                <!-- Note: value="" does NOT work for file inputs, remove it -->
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
                                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g,'')"
                                            value="{{ $user->name }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control bg-light border-0"
                                            placeholder="robert@company.com" name="email" value="{{ $user->email }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Phone <span class="text-danger">*</span>
                                        </label>

                                        <input type="tel" class="form-control bg-light border-0"
                                            placeholder="Enter 10 digit phone" name="phone" maxlength="10"
                                            pattern="[6-9][0-9]{9}" value="{{ $user->phone }}"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^([0-5])/, '').slice(0,10)">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Designation <span class="text-danger">*</span>
                                        </label>

                                        <select class="form-select bg-light border-0" name="designation" required>
                                            <option value="">Choose designation</option>
                                            <option value="hr head"
                                                {{ $user->designation == 'hr head' ? 'selected' : '' }}>HR Head</option>
                                            <option value="junier hr manager"
                                                {{ $user->designation == 'junier hr manager' ? 'selected' : '' }}>Junier
                                                HR Manager</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Joining Date <span class="text-danger">*</span>
                                        </label>

                                        <input type="date" class="form-control bg-light border-0"
                                            name = "joning_date" value = "{{ $user->joining }}">
                                    </div>

                                </div>

                            </div>

                        </div>


                        <hr class="my-4">


                        <!-- Address Section -->
                        <h6 class="mb-3 fw-bold text-primary small text-uppercase">
                            Address Information
                        </h6>

                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">
                                    Address <span class="text-danger">*</span>
                                </label>

                                <textarea class="form-control bg-light border-0"name="address" rows="2" placeholder="Street, Apartment, Landmark">{{ $user->address }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">
                                    State <span class="text-danger">*</span>
                                </label>
                                <select class="form-select bg-light border-0" id="state_id" name="state" required>
                                    <option disabled>Select State</option>
                                    @foreach ($state as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $user->state == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">
                                    District <span class="text-danger">*</span>
                                </label>

                                <select class="form-select bg-light border-0" id="district_id" name="district"
                                    required>
                                    <option disabled>Select District</option>
                                    @if ($user->state)
                                        @foreach ($districs as $d)
                                            <!-- $districts is the list of districts for $hr->state -->
                                            <option value="{{ $d->id }}"
                                                {{ $user->district == $d->id ? 'selected' : '' }}>
                                                {{ $d->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">
                                    City
                                </label>

                                <input type="text" class="form-control bg-light border-0"
                                    placeholder="City"name="city" value = "{{ $user->city }}">
                            </div>

                        </div>


                        <div class="mt-4 text-end">

                            <button type="reset" class="btn btn-outline-secondary">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i>
                                Save HR
                            </button>

                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });


        new Chart(document.getElementById('deptChart'), {
            type: 'bar',
            data: {
                labels: ['IT', 'HR', 'Finance', 'Sales', 'Ops', 'Design'],
                datasets: [{
                    data: [98, 92, 85, 78, 90, 95],
                    backgroundColor: '#4e73df',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });


        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Full-time', 'Contract', 'Intern'],
                datasets: [{
                    data: [80, 15, 5],
                    backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <script>
        $('#state_id').change(function() {

            var state_id = $(this).val();

            $.ajax({
                url: '/get-districts/' + state_id,
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

</body>

</html>

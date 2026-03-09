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
                    <i class="bi bi-pencil-square text-warning fs-4 me-2"></i>
                    <h6 class="mb-0 fw-bold">Edit Team Leader </h6>
                </div>

                <div class="card-body p-4">
                    <form id="prForm" action="{{ route('tm.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Profile Image -->
                            <div class="col-md-3 text-center">

                                <label class="form-label fw-bold text-muted">
                                    Profile Image
                                </label>

                                <div class="mb-3">

                                    <img id="imagePreview"
                                        src="{{ $user->image ? asset('images/teamleader/' . $user->image) : asset('upload_images/download.png') }}"
                                        class="rounded-circle border shadow" width="120" height="120"
                                        style="object-fit:cover;">

                                </div>

                                <input type="file" name="image" id="imageUpload" class="form-control"
                                    accept="image/*">

                            </div>


                            <!-- Form Fields -->
                            <div class="col-md-9">

                                <div class="row g-3">

                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Full Name
                                        </label>

                                        <input type="text" class="form-control bg-light border-0" name="name"
                                            value="{{ $user->name }}" required>

                                    </div>


                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Email
                                        </label>

                                        <input type="email" class="form-control bg-light border-0" name="email"
                                            value="{{ $user->email }}" required>

                                    </div>


                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Phone
                                        </label>

                                        <input type="tel" class="form-control bg-light border-0" name="phone"
                                            value="{{ $user->phone }}" maxlength="10">

                                    </div>


                                    <!-- Department -->
                                    <div class="col-md-6">

                                        <label class="form-label small fw-bold text-muted">
                                            Department
                                        </label>

                                        <select class="form-select bg-light border-0" name="department" id="department">

                                            <option value="">Select Department</option>

                                            @foreach ($department as $dep)
                                                <option value="{{ $dep->id }}"
                                                    {{ $user->department == $dep->id ? 'selected' : '' }}>

                                                    {{ $dep->department_name }}

                                                </option>
                                            @endforeach

                                        </select>

                                    </div>





                                    <!-- Joining Date -->
                                    <div class="col-md-6">

                                        <label class="form-label small fw-bold text-muted">
                                            Joining Date
                                        </label>

                                        <input type="date" class="form-control bg-light border-0" name="joning_date"
                                            value="{{ $user->joining }}">

                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr class="my-4">


                        <h6 class="mb-3 fw-bold text-primary small text-uppercase">
                            Address Information
                        </h6>


                        <div class="row g-3">

                            <!-- Address -->
                            <div class="col-12">

                                <label class="form-label small fw-bold text-muted">
                                    Address
                                </label>

                                <textarea class="form-control bg-light border-0" name="address" rows="2">{{ $user->address }}</textarea>

                            </div>


                            <!-- State -->
                            <div class="col-md-4">

                                <label class="form-label small fw-bold text-muted">
                                    State
                                </label>

                                <select class="form-select bg-light border-0" id="state_id" name="state">

                                    <option>Select State</option>

                                    @foreach ($state as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $user->state == $s->id ? 'selected' : '' }}>

                                            {{ $s->name }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            <!-- District -->
                            <div class="col-md-4">

                                <label class="form-label small fw-bold text-muted">
                                    District
                                </label>

                                <select class="form-select bg-light border-0" id="district_id" name="distric">

                                    <option value="">Select District</option>

                                    @foreach ($districs as $district)
                                        <option value="{{ $district->id }}"
                                            {{ $user->district == $district->id ? 'selected' : '' }}>

                                            {{ $district->name }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            <!-- City -->
                            <div class="col-md-4">

                                <label class="form-label small fw-bold text-muted">
                                    City
                                </label>

                                <input type="text" class="form-control bg-light border-0" name="city"
                                    value="{{ $user->city }}">

                            </div>

                        </div>


                        <div class="mt-4 text-end">

                            <button type="reset" class="btn btn-outline-secondary">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Team Leader
                            </button>

                        </div>

                    </form>
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
    <script>
        document.getElementById('prForm').addEventListener('submit', function(e) {

            e.preventDefault(); // stop form first

            const name = document.querySelector('[name="name"]').value.trim();
            const email = document.querySelector('[name="email"]').value.trim();
            const phone = document.querySelector('[name="phone"]').value.trim();
            const department = document.querySelector('[name="department"]').value;
            const joining = document.querySelector('[name="joning_date"]').value;
            const address = document.querySelector('[name="address"]').value.trim();
            const state = document.querySelector('[name="state"]').value;
            const district = document.querySelector('[name="distric"]').value;
            const image = document.getElementById('imageUpload').files.length;

            const phoneRegex = /^[6-9][0-9]{9}$/;
            const nameRegex = /^[A-Za-z\s]+$/;

            if (image === 0 && "{{ $user->image }}" === "") {
                toast('Profile image is required');
                return;
            }

            if (name === '') {
                toast('Full name is required');
                return;
            }

            if (!nameRegex.test(name)) {
                toast('Name must contain only letters');
                return;
            }

            if (email === '') {
                toast('Email is required');
                return;
            }

            if (!email.includes('@')) {
                toast('Email must contain @');
                return;
            }

            if (!phoneRegex.test(phone)) {
                toast('Phone must start 6-9 and be 10 digits');
                return;
            }

            if (department === '') {
                toast('Please select department');
                return;
            }

            if (joining === '') {
                toast('Joining date is required');
                return;
            }

            if (address === '') {
                toast('Address is required');
                return;
            }

            if (!state) {
                toast('Please select state');
                return;
            }

            if (!district) {
                toast('Please select district');
                return;
            }
            // SHOW LOADER
            document.getElementById("pageLoader").style.display = "flex";

            // If all valid submit form
            this.submit();

        });


        function toast(message) {

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: message,
                showConfirmButton: false,
                timer: 3000
            });

        }
    </script>



</body>

</html>

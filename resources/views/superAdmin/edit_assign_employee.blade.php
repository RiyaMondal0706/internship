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

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="bi bi-person-workspace text-primary fs-4 me-2"></i>
                    <h6 class="mb-0 fw-bold">Assign Employee / Intern</h6>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('assign.student.update', $assign->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <!-- Assign Type -->
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Assign Type
                                </label>

                                <select name="assign_type" class="form-select bg-light border-0" id="assign_type">
                                    <option value="">Select Type</option>

                                    @foreach ($designation as $des)
                                        <option value="{{ $des->code }}"
                                            {{ $assign->assign_type == $des->code ? 'selected' : '' }}>
                                            {{ $des->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>


                            <!-- Mentor -->
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Select Mentor / Team Leader
                                </label>

                                <select name="mentor_id" class="form-select bg-light border-0" id="mentor_list">

                                    <option value="{{ $mentor->id }}" selected>
                                        {{ $mentor->name }}
                                    </option>

                                </select>
                            </div>


                            <!-- Employee -->
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">
                                    Select Employee / Intern
                                </label>

                                <select name="user_id" class="form-select bg-light border-0" id="person_list">

                                    <option value="{{ $employee->id }}" selected>
                                        {{ $employee->name }}
                                    </option>

                                </select>
                            </div>


                            <div class="mt-4 text-end">

                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Update Assign
                                </button>

                            </div>

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
        $(document).ready(function() {

            $("#projectForm").on("submit", function(e) {

                let valid = true;

                // simple validation
                if ($("#project_title").val() == "") {
                    alert("Project Title is required");
                    valid = false;
                }

                if ($("#company_name").val() == "") {
                    alert("Company Name is required");
                    valid = false;
                }

                if ($("#domain").val() == "") {
                    alert("Please select project domain");
                    valid = false;
                }

                if ($("#start_date").val() == "") {
                    alert("Start Date is required");
                    valid = false;
                }

                if ($("#employee_required").val() == "") {
                    alert("Number of employee required");
                    valid = false;
                }

                if (valid) {
                    $("#pageLoader").fadeIn(); // show loader
                } else {
                    e.preventDefault(); // stop form submit
                    $("#pageLoader").fadeOut();
                }

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("#assign_type").change(function() {

                var type = $(this).val();

                $.ajax({
                    url: "{{ route('superadmin.assign.type.data') }}",
                    type: "GET",
                    data: {
                        type: type
                    },

                    success: function(response) {

                        $("#mentor_list").html('<option value="">Select Mentor</option>');
                        $("#person_list").html('<option value="">Select Person</option>');

                        $.each(response.mentors, function(key, value) {
                            $("#mentor_list").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });

                        $.each(response.users, function(key, value) {
                            $("#person_list").append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });

                    }

                });

            });

        });
    </script>
</body>

</html>

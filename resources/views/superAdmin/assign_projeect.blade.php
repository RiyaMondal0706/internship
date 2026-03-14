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
                    <form action="{{ route('assign.project.employee.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <!-- Designation -->
                            <div class="col-md-4">
                                <label class="form-label">Designation</label>
                                <select class="form-select" id="designation"name="designation">
                                    <option value="">Select Designation</option>

                                    @foreach ($designation as $des)
                                        <option value="{{ $des->code }}">{{ $des->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- Employee -->
                            <div class="col-md-4">
                                <label class="form-label">Employee</label>
                                <select name="employee_id" name = "employee"id="employee_list" class="form-select">
                                    <option value="">Select Employee</option>
                                </select>
                            </div>

                            <!-- Project -->
                            <div class="col-md-4">
                                <label class="form-label">Project</label>
                                <select name="project_id" id="project_list" name = "project" class="form-select">
                                    <option value="">Select Project</option>
                                </select>
                            </div>

                            <!-- Project Details -->
                            <div class="col-md-12">
                                <div id="project_details" class="border rounded p-3 bg-light">
                                    <label class="form-label"><b>What are you doing?</b></label>

                                    <textarea name="work" class="form-control" rows="5" placeholder="Write your work details here..."></textarea>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button class="btn btn-primary">Assign Project</button>
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

            $("#designation").change(function() {

                let designation = $(this).val();

                $.ajax({
                    url: "{{ route('project.designation.data') }}",
                    type: "GET",
                    data: {
                        designation: designation
                    },

                    success: function(res) {
                        // alert("ok");
                        $("#employee_list").html('<option>Select Employee</option>');
                        $("#project_list").html('<option>Select Project</option>');

                        $.each(res.employees, function(key, val) {
                            $("#employee_list").append('<option value="' + val.id +
                                '">' + val.name + '</option>');
                        });

                        $.each(res.projects, function(key, val) {
                            $("#project_list").append('<option value="' + val.id +
                                '">' + val.project_title + '</option>');
                        });

                    }

                });

            });

            $("#project_list").change(function() {

                let desc = $(this).find(':selected').data('desc');
                $("#project_desc").text(desc);

            });

        });
    </script>


</body>

</html>

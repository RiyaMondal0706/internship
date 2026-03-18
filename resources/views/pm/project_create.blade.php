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
    @include('layouts.pm.sidebar')


    <!-- MAIN CONTENT -->

    <div id="main-content">


        <!-- HEADER -->

        @include('layouts.pm.header')


        <!-- CONTENT -->

        <div class="container-fluid p-4">

            <div class="card stat-card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="bi bi-person-plus-fill text-primary fs-4 me-2"></i>
                    <h6 class="mb-0 fw-bold">Register New Project</h6>
                </div>

                <div class="card-body p-4">
                    <form id="projectForm" action="{{ route('pm.project.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">

                            <!-- Project Image -->


                            <div class="col-md-9">

                                <div class="row g-3">

                                    <!-- Project Title -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Project Title
                                        </label>

                                        <input type="text" name="project_title"
                                            class="form-control bg-light border-0" placeholder="Enter project title"
                                            id = "project_title">
                                    </div>


                                    <!-- Company Name -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Company Name
                                        </label>

                                        <input type="text" name="company_name" class="form-control bg-light border-0"
                                            placeholder="Enter company name" id= "company_name">
                                    </div>


                                    <!-- Project Domain -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Project Domain
                                        </label>

                                        <select name="domain" class="form-select bg-light border-0" id="domain">
                                            <option value="">Select Domain</option>

                                            @foreach ($department as $department)
                                                @if ($department->id != 6 && $department->id != 8)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->department_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Technology -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Technology Required
                                        </label>

                                        <input type="text" name="technology" class="form-control bg-light border-0"
                                            placeholder="Example: Laravel, React, Python" id = "technology">
                                    </div>


                                    <!-- Start Date -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Start Date
                                        </label>

                                        <input type="date" id = "start_date" name="start_date"
                                            class="form-control bg-light border-0">
                                    </div>


                                    <!-- End Date -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            End Date
                                        </label>

                                        <input type="date" id = "end_date" name="end_date"
                                            class="form-control bg-light border-0">
                                    </div>


                                    <!-- Required Interns -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Number of Employee Required
                                        </label>

                                        <input type="number" name="employee_required"
                                            class="form-control bg-light border-0"
                                            placeholder="Enter number of employee" id = "employee_required">
                                    </div>
                                    <!-- Project Document Upload -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">
                                            Project Document
                                        </label>

                                        <input type="file" name="project_document" id = "project_document"
                                            class="form-control bg-light border-0" accept=".pdf,.doc,.docx,.ppt,.pptx">
                                    </div>

                                </div>

                            </div>

                        </div>


                        <hr class="my-4">


                        <!-- Project Description -->

                        <h6 class="mb-3 fw-bold text-primary small text-uppercase">
                            Project Description
                        </h6>

                        <div class="row">

                            <div class="col-12">

                                <label class="form-label small fw-bold text-muted">
                                    Project Details
                                </label>

                                <textarea name="description" rows="4" class="form-control bg-light border-0"
                                    placeholder="Explain project requirements, tasks and expected output">
</textarea>

                            </div>

                        </div>


                        <div class="mt-4 text-end">

                            <button type="reset" class="btn btn-outline-secondary">
                                Discard
                            </button>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i>
                                Create Project
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


</body>

</html>

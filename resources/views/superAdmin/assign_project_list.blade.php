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

        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h6 class="mb-0 fw-bold text-dark">Assign List</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('hr.assign.student') }}"> <button class="btn btn-primary btn-sm px-3"><i
                                class="bi bi-plus-lg me-1"></i> Add New</button>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4">Project</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Work</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ass as $ass)
                            <tr>
                                @php
                                    $project = DB::connection('mysql_second')
                                        ->table('project')
                                        ->where('id', $ass->project_id)
                                        ->first();
                                    $emp = DB::connection('mysql')
                                        ->table('employees')
                                        ->where('id', $ass->employee_id)
                                        ->first();

                                @endphp
                                <td>{{ $project->project_title }}</td>
                                <td>{{ $emp->name }}</td>
                                <td>
                                    @if ($ass->designation == 'teamlead')
                                        Team Leader
                                    @elseif($ass->designation == 'employee')
                                        Employe
                                    @elseif($ass->designation == 'intern')
                                        Intern
                                    @else
                                        {{ $ass->designation }}
                                    @endif
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($ass->work, 15) }}</td>
                                <td>
                                    <a href="{{ route('assign_project.status', $ass->id) }}"
                                        style="text-decoration:none;">
                                        @if ($ass->status == 1)
                                            <span class="badge bg-success px-3 py-2">Active</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">Inactive</span>
                                        @endif
                                    </a>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            $(".deleteBtn").click(function() {

                let form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This assignment will be deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, Delete it"
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            });

        });
    </script>

</body>

</html>

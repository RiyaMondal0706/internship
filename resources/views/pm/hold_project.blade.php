<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project Management | CorpPanel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        #main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }
    </style>

</head>

<body>

    @include('layouts.pm.sidebar')

    <div id="main-content">

        @include('layouts.pm.header')

        <div class="container-fluid p-4">

            <div class="card shadow-sm border-0">

                <div class="card-header d-flex justify-content-between">

                    <h6 class="fw-bold">Project Management List</h6>

                    <a href="{{ route('pm.project.create') }}">
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Add New
                        </button>
                    </a>

                </div>


                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead class="table-light">

                            <tr>

                                <th>Project Title</th>
                                <th>Company</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($project as $item)
                                <tr>

                                    <td>

                                        {{ \Illuminate\Support\Str::limit($item->project_title, 10) }}

                                        <br>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary viewProject"
                                            data-id="{{ $item->id }}">

                                            <i class="bi bi-eye"></i> Details

                                        </a>

                                    </td>


                                    <td>{{ $item->company_name }}</td>


                                    <td>
                                        {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}
                                    </td>


                                    <td>

                                        @php

                                            $endDate = \Carbon\Carbon::parse($item->end_date);
                                            $today = \Carbon\Carbon::today();
                                            $daysLeft = $today->diffInDays($endDate, false);

                                        @endphp

                                        {{ $endDate->format('d M Y') }}

                                        <br>

                                        @if ($daysLeft <= 3)
                                            <span class="text-danger fw-bold">
                                                {{ $daysLeft }} Days Left
                                            </span>
                                        @elseif($daysLeft <= 10)
                                            <span class="text-warning fw-bold">
                                                {{ $daysLeft }} Days Left
                                            </span>
                                        @else
                                            <span class="text-success fw-bold">
                                                {{ $daysLeft }} Days Left
                                            </span>
                                        @endif

                                    </td>


                                    <td>

                                        <span class="badge bg-danger">Hold</span>

                                    </td>


                                    <td class="text-end">

                                        <a href="{{ route('pm.project.edit', $item->id) }}"
                                            class="btn btn-sm btn-light border">

                                            <i class="bi bi-pencil-fill text-primary"></i>

                                        </a>

                                        @php

                                            $ass = DB::connection('mysql_second')
                                                ->table('assign_project')
                                                ->where('project_id', $item->id)
                                                ->first();

                                            $emp = DB::connection('mysql')
                                                ->table('employees')
                                                ->where('id', $ass->employee_id)
                                                ->first();

                                            if ($emp) {
                                                $employeeName = $emp->name;
                                            }

                                        @endphp


                                        <a href="#" class="btn btn-sm btn-light border reassignBtn"
                                            data-id="{{ $item->id }}" data-name="{{ $employeeName }}">

                                            <i class="bi bi-arrow-repeat text-info"></i>

                                        </a>


                                        <form action="{{ route('project.delete', $item->id) }}" method="POST"
                                            style="display:inline;">

                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-sm btn-light border delete-btn">

                                                <i class="bi bi-trash text-danger"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- DELETE ALERT -->

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {

            button.addEventListener('click', function() {

                let form = this.closest('form');

                Swal.fire({

                    title: "Are you sure?",
                    text: "Delete this project?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Yes Delete"

                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            });

        });
    </script>


    <!-- REASSIGN SCRIPT -->

    <script>
        $(document).on('click', '.reassignBtn', function() {

            let projectId = $(this).data('id');
            let personName = $(this).data('name');

            Swal.fire({

                title: "Reassign Project",

                html: `
<p>Current Person : <b>${personName}</b></p>
<p>Do you want same person?</p>
`,

                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No"

            }).then((result) => {

                if (result.isConfirmed) {

                    window.location.href = "/superadmin/project/reassign/" + projectId + "/same";

                } else {

                    Swal.fire({

                        title: "Select Employee",

                        html: `

<select id="designation" class="swal2-input">

<option value="">Select Designation</option>
<option value="teamlead">Team Leader</option>
<option value="mentor">Mentor</option>
<option value="intern">Intern</option>

</select>

<select id="employee" class="swal2-input">

<option value="">Select Employee</option>

</select>

`,

                        confirmButtonText: "Assign"

                    }).then(() => {

                        let emp = $("#employee").val();

                        if (emp) {

                            window.location.href = "/superadmin/project/reassign/" + projectId +
                                "/new/" + emp;

                        }

                    });

                }

            });

        });
    </script>


    <!-- LOAD EMPLOYEE -->

    <script>
        $(document).on('change', '#designation', function() {

            let designation = $(this).val();

            if (designation != '') {

                $.ajax({

                    url: "/superadmin/get-employees/" + designation,
                    type: "GET",

                    success: function(data) {

                        $("#employee").html('<option value="">Select Employee</option>');

                        $.each(data, function(key, value) {

                            $("#employee").append(
                                '<option value="' + value.id + '">' + value.name +
                                '</option>'
                            );

                        });

                    }

                });

            }

        });
    </script>


</body>

</html>

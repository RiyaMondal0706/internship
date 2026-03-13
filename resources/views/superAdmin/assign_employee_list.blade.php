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
                    <a href="{{ route('assign.student') }}"> <button class="btn btn-primary btn-sm px-3"><i
                                class="bi bi-plus-lg me-1"></i> Add New</button>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4">Mentor / Team Leader Name</th>
                            <th>Designation</th>
                            <th>Employee / Intern Name</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($assign as $mentor_id => $rows)
                            @php
                                $mentor = DB::table('employees')->where('id', $mentor_id)->first();
                                $designation = $mentor->designation == 'teamlead' ? 'Team Leader' : 'Mentor';
                            @endphp

                            @foreach ($rows as $key => $row)
                                @php
                                    $intern = DB::table('employees')->where('id', $row->employee_id)->first();
                                @endphp

                                <tr>

                                    {{-- Show mentor only once --}}
                                    @if ($key == 0)
                                        <td rowspan="{{ count($rows) }}" class="ps-4">
                                            {{ $mentor->name }}
                                        </td>

                                        <td rowspan="{{ count($rows) }}">
                                            {{ $designation }}
                                        </td>
                                    @endif

                                    <td>{{ $intern->name }}</td>

                                    <td>Active</td>

                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-danger">Remove</button>
                                    </td>

                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




</body>

</html>

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
    @include('layouts.intern.sidebar')


    <!-- MAIN CONTENT -->

    <div id="main-content">


        <!-- HEADER -->

        @include('layouts.intern.header')


        <!-- CONTENT -->

        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h6 class="mb-0 fw-bold text-dark">Assign Employee List</h6>
                <div class="d-flex gap-2">

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4">Employee Name</th>
                            <th>Contact Info</th>
                            <th>Designation</th>
                            <th>Profile </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            @php
                                $dep = DB::table('subdepartment')->where('id', $employee->subdepartment)->first();
                            @endphp

                            <tr>
                                <!-- Employee Name + Image -->
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('upload_images/' . ($employee->image ?? 'default.png')) }}"
                                            class="rounded-circle me-3" width="38">

                                        <div>
                                            <div class="fw-bold mb-0">{{ $employee->name }}</div>
                                            <small class="text-muted">ID: #{{ $employee->employee_code }}</small>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Info -->
                                <td>
                                    <div class="small fw-semibold">{{ $employee->email }}</div>
                                    <div class="small text-muted">+91 {{ $employee->phone }}</div>
                                </td>

                                <!-- Department -->
                                <td>
                                    <span class="badge bg-light text-dark border fw-medium">
                                        {{ strtoupper($dep->subdepartment_name ?? 'N/A') }}
                                    </span>
                                </td>

                                <!-- Joining Date -->
                                <td class="small text-secondary">
                                    {{ \Carbon\Carbon::parse($employee->joining_date)->format('d F Y') }}
                                </td>

                                <!-- Address -->
                                <td class="small">
                                    {{ strtoupper($employee->address) }}
                                </td>

                                <!-- Status -->
                                <td>
                                    @if ($employee->status == 1)
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle px-3">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- View Button -->
                                <td>
                                    <a href="{{ route('intern.hr_view.profile', ['id' => $employee->id]) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <!-- If no employees -->
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    🚫 No employee found — no intern assigned
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>

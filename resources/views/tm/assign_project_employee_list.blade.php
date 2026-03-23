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
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: .3s;
        }
    </style>

</head>

<body>


    @include('layouts.tm.sidebar')

    <div id="main-content">

        @include('layouts.tm.header')


        <div class="container-fluid p-4">

            <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">

                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">

                </div>


                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr style="font-size:12px; text-transform:uppercase; letter-spacing:0.6px;">
                                <th class="ps-4">Project</th>
                                <th>Timeline</th>
                                <th>Employee</th>
                                <th>Submission</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($projects as $item)
                                <tr style="font-size:13px;">

                                    <!-- Project Title -->
                                    <td class="ps-4">
                                        <div class="fw-semibold text-dark">
                                            {{ $item->project_title }}
                                        </div>

                                    </td>

                                    <!-- Timeline -->
                                    <td>
                                        <div class="small text-muted">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}
                                        </div>

                                        <div class="small text-muted">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
                                        </div>

                                        @php
                                            $end = \Carbon\Carbon::parse($item->end_date);
                                            $today = \Carbon\Carbon::today();
                                            $days = $today->diffInDays($end, false);
                                        @endphp

                                        <div>
                                            @if ($days < 0)
                                                <span class="badge bg-danger-subtle text-danger">Expired</span>
                                            @elseif($days <= 3)
                                                <span class="badge bg-danger-subtle text-danger">{{ $days }}
                                                    Days Left</span>
                                            @elseif($days <= 7)
                                                <span class="badge bg-warning-subtle text-warning">{{ $days }}
                                                    Days Left</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success">{{ $days }}
                                                    Days Left</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Employee -->
                                    <td>
                                        @php
                                            $empName =
                                                $employees[$item->reassign_employee_id] ??
                                                ($employees[$item->reassign_employee_id] ?? null);
                                        @endphp

                                        @if ($empName)
                                            <span class="badge bg-info-subtle text-dark px-3 py-2">
                                                <i class="bi bi-person me-1"></i> {{ $empName }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border px-3 py-2">
                                                Not Assigned
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Submission -->
                                    <td>
                                        @if ($item->status == 2)
                                            <span class="badge bg-warning-subtle text-dark px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i> Pending
                                            </span>
                                        @elseif ($item->status == 3)
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i> Completed
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No Projects Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>



    <!-- PROJECT DETAILS MODAL -->

    <div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Project Details</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="projectDetails">

                    <div class="text-center p-4">
                        <div class="spinner-border text-primary"></div>
                    </div>

                </div>

            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>

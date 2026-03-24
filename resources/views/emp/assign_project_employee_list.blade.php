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


    @include('layouts.emp.sidebar')

    <div id="main-content">

        @include('layouts.emp.header')


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
                                        @if ($item->status == 1)
                                            <!-- Pending -->
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($item->status == 2)
                                            <!-- Copy Link -->
                                            <button class="btn btn-sm btn-outline-primary copy-link-btn"
                                                data-link="{{ $item->project_link }}">
                                                <i class="bi bi-link-45deg"></i>
                                            </button>

                                            <!-- Schedule -->
                                            <button class="btn btn-sm btn-warning note-btn"
                                                data-id="{{ $item->project_id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        @elseif ($item->status == 3)
                                            <!-- Copy Link -->
                                            <button class="btn btn-sm btn-outline-primary copy-link-btn"
                                                data-link="{{ $item->project_link }}">
                                                <i class="bi bi-link-45deg"></i>
                                            </button>

                                            <!-- Schedule -->
                                            <button class="btn btn-sm btn-warning note-btn"
                                                data-id="{{ $item->project_id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <span class="badge bg-success">Submission Done</span>

                                            <button class="btn btn-sm btn-primary review-btn" data-id="">
                                                <i class="bi bi-star"></i> Review
                                            </button>
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
    <div class="modal fade" id="noteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Project Notes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- LEFT SIDE (DATES) -->
                        <div class="col-md-4 border-end">
                            <ul class="list-group" id="noteDateList"></ul>
                        </div>

                        <!-- RIGHT SIDE -->
                        <div class="col-md-8">

                            <form id="noteForm">
                                @csrf

                                <input type="hidden" id="note_project_id" name="project_id">

                                <!-- TODAY DATE ONLY -->
                                <div class="mb-2">
                                    <label>Date</label>

                                    <!-- Visible -->
                                    <input type="text" id="show_today" class="form-control" readonly>

                                    <!-- Hidden -->
                                    <input type="hidden" id="note_date" name="date">
                                </div>

                                <!-- NOTE -->
                                <div class="mb-2">
                                    <label>Note</label>
                                    <textarea id="note_text" name="note" class="form-control" rows="5" placeholder="Write today's work..."></textarea>
                                </div>


                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on("click", ".copy-link-btn", function() {

            let link = $(this).data("link");

            if (!link) {
                Swal.fire("Error", "No link available", "error");
                return;
            }

            // Copy to clipboard
            navigator.clipboard.writeText(link).then(function() {

                Swal.fire({
                    icon: "success",
                    title: "Copied!",
                    text: "Project link copied successfully",
                    timer: 1500,
                    showConfirmButton: false
                });

            }).catch(function() {

                Swal.fire("Error", "Failed to copy", "error");

            });

        });
    </script>

    <script>
        $(document).on("click", ".schedule-btn", function() {

            let project_id = $(this).data("project");
            let mentor_id = $(this).data("mentor");

            $("#sch_project_id").val(project_id);
            $("#sch_mentor_id").val(mentor_id);
            $("#sch_note").val("");

            let modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
            modal.show();
        });
    </script>
    <script>
        // CSRF setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // OPEN MODAL
        $(document).on("click", ".note-btn", function() {

            let project_id = $(this).data("id");

            $("#note_project_id").val(project_id);

            let modal = new bootstrap.Modal(document.getElementById('noteModal'));
            modal.show();

            // TODAY DATE
            let today = new Date().toISOString().split('T')[0];

            $("#show_today").val(today);
            $("#note_date").val(today);
            $("#note_text").val("");

            // LOAD OLD NOTES
            $.ajax({
                url: "/intern/project/notes/" + project_id,
                method: "GET",
                success: function(res) {

                    let list = "";

                    if (res.length === 0) {
                        list = "<li class='list-group-item text-muted'>No notes found</li>";
                    }

                    res.forEach(item => {
                        list += `
                    <li class="list-group-item note-date-item"
                        data-date="${item.date}"
                        data-note="${item.note}">
                        ${item.date}
                    </li>
                `;
                    });

                    $("#noteDateList").html(list);
                }
            });

        });


        // CLICK OLD DATE → VIEW NOTE
        $(document).on("click", ".note-date-item", function() {

            $(".note-date-item").removeClass("active");
            $(this).addClass("active");

            let date = $(this).data("date");
            let note = $(this).data("note");

            $("#show_today").val(date);
            $("#note_date").val(date);
            $("#note_text").val(note);
        });


        // SAVE NOTE
        $("#noteForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "/intern/project/notes/store",
                method: "POST",
                data: $(this).serialize(),
                success: function() {

                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: "Note saved successfully"
                    });

                }
            });
        });
    </script>
</body>

</html>

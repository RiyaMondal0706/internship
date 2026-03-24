<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Project Management | CorpPanel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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


    @include('layouts.superadmin.sidebar')

    <div id="main-content">

        @include('layouts.superadmin.header')


        <div class="container-fluid p-4">

            <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">

                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">

                    <h6 class="mb-0 fw-bold text-dark">Project Management List</h6>

                    <a href="{{ route('project.create') }}">
                        <button class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-plus-lg me-1"></i> Add New
                        </button>
                    </a>

                </div>


                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr style="font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">

                                <th class="ps-4">Project Title</th>
                                <th>Company Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th class="text-end pe-4">Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($projects as $item)
                                <tr style="font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">

                                    <td class="ps-4">

                                        <div class="fw-semibold">
                                            {{ \Illuminate\Support\Str::limit($item->project_title, 10) }}
                                        </div>

                                        <a href="javascript:void(0)"
                                            class="btn btn-sm btn-outline-primary mt-1 viewProject"
                                            data-id="{{ $item->id }}">

                                            <i class="bi bi-eye me-1"></i> Project Details
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

                                        <!-- Normal Date -->
                                        <span>{{ $endDate->format('d M Y') }}</span>

                                        <br>

                                        <!-- Days Left with Color -->
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



                                    <td class="text-end pe-4">

                                        @if ($item->status == 1)
                                            <!-- 🔗 Link Button -->
                                            <button class="btn btn-sm btn-outline-primary open-link-modal"
                                                data-id="{{ $item->id }}">
                                                <i class="bi bi-link-45deg"></i>
                                            </button>

                                            <!-- 📝 Note Button -->
                                            <button class="btn btn-sm btn-warning note-btn"
                                                data-id="{{ $item->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- 📤 Submit Button -->
                                            <button class="btn btn-sm btn-success submit-btn"
                                                data-id="{{ $item->id }}">
                                                <i class="bi bi-upload"></i> Submit
                                            </button>
                                        @elseif ($item->status == 2)
                                            <!-- ✅ Completed -->
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Completed
                                            </span>
                                        @else
                                            <!-- Optional (for other statuses) -->
                                            <span class="badge bg-secondary">Not Available</span>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

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
    <div class="modal fade" id="linkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Submit Project Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="linkForm" method="POST" action="{{ route('project.submit.link') }}">
                    @csrf

                    <div class="modal-body">

                        <input type="hidden" name="project_id" id="project_id">

                        <label class="form-label">Project Link</label>
                        <input type="url" name="project_link" class="form-control"
                            placeholder="Enter project link (https://...)" required>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>

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

                                <button type="submit" class="btn btn-primary">
                                    Save Note
                                </button>

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


    <!-- DELETE ALERT -->

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {

                let form = this.closest('form');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this project!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });
        });
    </script>



    <!-- AJAX PROJECT DETAILS -->

    <script>
        $(document).on("click", ".viewProject", function() {

            let project_id = $(this).data("id");

            let modal = new bootstrap.Modal(document.getElementById('projectModal'));
            modal.show();

            $("#projectDetails").html(
                '<div class="text-center p-4"><div class="spinner-border text-primary"></div></div>'
            );

            $.ajax({
                url: "{{ url('/intern/project/details') }}/" + project_id,
                method: "GET",

                success: function(response) {
                    $("#projectDetails").html(response);
                },

                error: function() {
                    $("#projectDetails").html("<div class='text-danger'>Error loading project</div>");
                }
            });

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
                url: "/Employee/project/notes/" + project_id,
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
                url: "/Employee/project/notes/store",
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
    <script>
        $(document).on("click", ".submit-btn", function() {

            let projectId = $(this).data("id");

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to submit this project?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('intern.project.submit') }}",
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            project_id: projectId
                        },

                        success: function(res) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Submitted!',
                                text: 'Project completed successfully',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // reload page or update UI
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        },

                        error: function() {
                            Swal.fire("Error", "Something went wrong", "error");
                        }
                    });

                }

            });

        });
    </script>
</body>

</html>

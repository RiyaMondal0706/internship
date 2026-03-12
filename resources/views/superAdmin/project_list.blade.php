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
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($project as $item)
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

                                    <td>
                                        @if ($item->status == 0)
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($item->status == 1)
                                            <span class="badge bg-primary">Ongoing</span>
                                        @elseif($item->status == 2)
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($item->status == 3)
                                            <span class="badge bg-danger">Hold</span>
                                        @endif
                                    </td>

                                    <td class="text-end pe-4">

                                        {{-- Status = 0 (Pending) --}}
                                        @if ($item->status == 0)
                                            <!-- Edit -->
                                            <a href="{{ route('project.edit', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-pencil-fill text-primary" title="Edit "></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('project.delete', $item->id) }}" method="POST"
                                                class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-sm btn-light border delete-btn">
                                                    <i class="bi bi-trash text-danger" title="Delete Project"></i>
                                                </button>
                                            </form>

                                            <!-- Pending -->
                                            <a href="{{ route('project.hold', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-pause-circle text-danger" title="Hold"></i>
                                            </a>


                                            {{-- Status = 1 (Ongoing) --}}
                                        @elseif ($item->status == 1)
                                            <!-- Edit -->
                                            <a href="{{ route('project.edit', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-pencil-fill text-primary"title="Edit"></i>
                                            </a>
                                            <a href="{{ route('project.hold', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-pause-circle text-danger" title="Hold"></i>
                                            </a>

                                            {{-- Status = 2 (Completed) --}}
                                        @elseif ($item->status == 2)
                                            <!-- View -->
                                            <a href="{{ route('project.view', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-eye text-success" title="View"></i>
                                            </a>

                                            <!-- Reassign -->
                                            <a href="{{ route('project.reassign', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-arrow-repeat text-info" title="Reassign"></i>
                                            </a>


                                            {{-- Status = 3 (Hold) --}}
                                        @elseif ($item->status == 3)
                                            <!-- Edit -->
                                            <a href="{{ route('project.edit', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-pencil-fill text-primary" title="Edit"></i>
                                            </a>

                                            <!-- Reassign -->
                                            <a href="{{ route('project.reassign', $item->id) }}"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-arrow-repeat text-info" title="Reassign"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('project.delete', $item->id) }}" method="POST"
                                                class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-sm btn-light border delete-btn">
                                                    <i class="bi bi-trash text-danger" title="Delete Project"></i>
                                                </button>
                                            </form>
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
                url: "{{ url('project/details') }}/" + project_id,
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


</body>

</html>

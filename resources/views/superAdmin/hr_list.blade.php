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
                <h6 class="mb-0 fw-bold text-dark">HR Management List</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('hr.create') }}"> <button class="btn btn-primary btn-sm px-3"><i
                                class="bi bi-plus-lg me-1"></i> Add New</button>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4">HR Name</th>
                            <th>Contact Info</th>
                            <th>Designation</th>
                            <th>Joining Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hrs as $hr)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/hr/' . $hr->image) }}" class="rounded-circle me-3"
                                            width="38">
                                        <div>
                                            <div class="fw-bold mb-0">{{ $hr->name }}</div>
                                            <small class="text-muted">ID: #HR-9921</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-semibold">{{ $hr->email }}</div>
                                    <div class="small text-muted">+91 {{ $hr->phone }}</div>
                                </td>
                                <td><span
                                        class="badge bg-light text-dark border fw-medium">{{ strtoupper($hr->designation) }}</span>
                                </td>
                                <td class="small text-secondary">
                                    {{ \Carbon\Carbon::parse($hr->joining)->format('d F Y') }}</td>
                                <td class="small"> {{ strtoupper($hr->address) }}</td>
                                <td>
                                    <a href="{{ route('hr.status', $hr->id) }}">
                                        @if ($hr->status == 1)
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
                                    </a>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm border" data-bs-toggle="dropdown"><i
                                                class="bi bi-three-dots"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('hr.view.profile', ['id' => $hr->id]) }}">
                                                    <i class="bi bi-eye me-2"></i> View Profile
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('hr.edit', $hr->id) }}"><i
                                                        class="bi bi-pencil me-2"></i>
                                                    Edit</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('hr.delete', $hr->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this HR?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </button>

                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --sidebar-width: 280px;
            --bg-dark: #111827;
            --bg-accent: #1f2937;
            --text-muted: #9ca3af;
            --text-light: #f3f4f6;
            --primary-blue: #3b82f6;
        }

        body {
            background-color: #f3f4f6;
            display: flex;
        }

        /* Sidebar Container */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            /* important */
            background-color: var(--bg-dark);
            color: var(--text-light);
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            /* enable vertical scroll */
            overflow-x: hidden;
            /* hide horizontal scroll */
        }

        /* Brand Section */
        #sidebar .brand-area {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Main Nav Links */
        .nav-link {
            color: var(--text-muted);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s;
            border-radius: 8px;
            margin: 4px 12px;
            text-decoration: none;
        }

        .nav-link:hover {
            background-color: var(--bg-accent);
            color: var(--text-light);
        }

        .nav-link.active {
            background-color: var(--primary-blue);
            color: white !important;
        }

        .nav-link i:first-child {
            font-size: 1.1rem;
            width: 25px;
        }

        /* Chevron Animation */
        .bi-chevron-down {
            font-size: 0.75rem;
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        [aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        /* Multi-level Nesting Styles */
        .collapse-inner-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 10px;
        }

        /* Level 2 Indentation (Categories like HR, PM) */
        #employeesMenu .nav-link {
            padding-left: 45px;
            font-size: 0.9rem;
        }

        /* Level 3 Indentation (Actions like Create, List) */
        #hrMenu .nav-link,
        #pmMenu .nav-link,
        #mentorMenu .nav-link,
        #tlMenu .nav-link,
        #internMenu .nav-link {
            padding-left: 65px;
            font-size: 0.85rem;
            opacity: 0.8;
            border-left: 1px solid #374151;
            margin-left: 35px;
            border-radius: 0;
        }

        /* Scrollbar Styling */
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: #374151;
        }

        /* Content placeholder to show sidebar fixed position */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 40px;
            width: 100%;
        }
    </style>
</head>

<body>

    <nav id="sidebar">
        <div class="brand-area">
            <h5 class="text-white fw-bold mb-0">
                <i class="bi bi-person-workspace me-2 text-primary"></i> HR
            </h5>
        </div>

        <div class="nav flex-column mt-3">
            <a href="{{ route('hr.dashboard') }}" class="nav-link active">
                <i class="bi bi-speedometer2 me-3"></i>Dashboard
            </a>
            <div class="nav-item">
                <a href="#employeesMenu" class="nav-link" data-bs-toggle="collapse" role="button">
                    <i class="bi bi-people me-3"></i> Employees
                    <i class="bi bi-chevron-down"></i>
                </a>

                <ul class="collapse list-unstyled mb-0" id="employeesMenu">

                    <!-- CREATE -->
                    <li class="nav-item">
                        <a href="{{ route('hr.employee.create') }}" class="nav-link">
                            <i class="bi bi-plus-circle me-2"></i> Create
                        </a>
                    </li>

                    <!-- LIST -->
                    <li class="nav-item">
                        <a href="#employeeListMenu" class="nav-link" data-bs-toggle="collapse">
                            <i class="bi bi-list-ul me-2"></i> List
                            <i class="bi bi-chevron-down"></i>
                        </a>

                        <ul class="collapse list-unstyled" id="employeeListMenu">
                            <li><a href="{{ route('hr.hr_list') }}" class="nav-link">HR</a></li>
                            <li><a href="{{ route('hr.project_manager.list') }}" class="nav-link">Project Manager</a>
                            </li>
                            <li><a href="{{ route('hr.tm.list') }}" class="nav-link">Team Leader</a></li>
                            <li><a href="{{ route('hr.mentor.list') }}" class="nav-link">Employee</a></li>
                            <li><a href="{{ route('hr.intern.list') }}" class="nav-link">Intern</a></li>
                        </ul>
                    </li>

                </ul>
            </div>

            <li class="nav-item">

                <a class="nav-link" data-bs-toggle="collapse" href="#projectMenu">
                    <i class="bi bi-folder2-open me-3"></i> Project
                    <i class="bi bi-chevron-down float-end"></i>
                </a>
                <ul class="collapse list-unstyled ps-4" id="projectMenu">

                    <li>
                        <a href="{{ route('hr.project.list') }}" class="nav-link">
                            <i class="bi bi-list me-2"></i> List
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hr.project.ongoing') }}" class="nav-link">
                            <i class="bi bi-play-circle me-2"></i> Ongoing
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('hr.project.pending') }}" class="nav-link">
                            <i class="bi bi-hourglass-split me-2"></i> Pending
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('hr.project.hold.list') }}" class="nav-link">
                            <i class="bi bi-pause-circle me-2"></i> Hold
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hr.project.completed') }}"class="nav-link">
                            <i class="bi bi-check-circle me-2"></i> Completed
                        </a>
                    </li>


                </ul>

            </li>
            <li class="nav-item">

                <a class="nav-link" data-bs-toggle="collapse" href="#assignMenu">
                    <i class="bi bi-diagram-3 me-3"></i> Assign
                    <i class="bi bi-chevron-down float-end"></i>
                </a>

                <div class="collapse" id="assignMenu">

                    <ul class="nav flex-column ms-4">

                        <!-- Assign Project -->
                        <li class="nav-item">
                            <a href="{{ route('assign.project') }}" class="nav-link">
                                <i class="bi bi-kanban me-2"></i> Assign Project
                            </a>
                        </li>

                        <!-- Assign Student Dropdown -->
                        <ul class="nav-item">

                            <a class="nav-link" data-bs-toggle="collapse" href="#assignStudentMenu">
                                <i class="bi bi-person-check me-2"></i> Assign Employee
                                <i class="bi bi-chevron-down float-end"></i>
                            </a>

                            <div class="collapse" id="assignStudentMenu">
                                <ul class="nav flex-column ms-4">

                                    <li class="nav-item">
                                        <a href="{{ route('hr.assign.student') }}" class="nav-link">
                                            <i class="bi bi-person-plus me-2"></i> Assign Employee
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('hr.assign.employee.list') }}" class="nav-link">
                                            <i class="bi bi-list-check me-2"></i> Assign Employee List
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </ul>

                    </ul>

                </div>

            </li> <a href="#" class="nav-link"><i class="bi bi-gear me-3"></i>Settings</a>
        </div>
    </nav>

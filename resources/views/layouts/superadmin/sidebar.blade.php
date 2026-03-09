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
            min-height: 100vh;
            background-color: var(--bg-dark);
            color: var(--text-light);
            transition: all 0.3s ease;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
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
            width: 5px;
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
                <i class="bi bi-person-workspace me-2 text-primary"></i> SUPERADMIN
            </h5>
        </div>

        <div class="nav flex-column mt-3">
            <a href="{{ route('superadmin.dashboard') }}" class="nav-link active">
                <i class="bi bi-speedometer2 me-3"></i>Dashboard
            </a>

            <div class="nav-item">
                <a href="#employeesMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false">
                    <i class="bi bi-people me-3"></i> Employees
                    <i class="bi bi-chevron-down"></i>
                </a>

                <ul class="collapse list-unstyled mb-0" id="employeesMenu">
                    <li class="nav-item">
                        <a href="#hrMenu" class="nav-link" data-bs-toggle="collapse" role="button">
                            HR <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="hrMenu">
                            <li><a href="{{ route('hr.create') }}" class="nav-link">Create</a></li>
                            <li><a href="{{ route('hr.list') }}" class="nav-link">List</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#pmMenu" class="nav-link" data-bs-toggle="collapse" role="button">
                            Project Manager <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="pmMenu">
                            <li><a href="{{ route('project_manager.create') }}" class="nav-link">Create</a></li>
                            <li><a href="{{ route('project_manager.list') }}" class="nav-link">List</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#mentorMenu" class="nav-link" data-bs-toggle="collapse" role="button">
                            Mentor <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="mentorMenu">
                            <li><a href="{{ route('mentor.create') }}" class="nav-link">Create</a></li>
                            <li><a href="{{ route('mentor.list') }}" class="nav-link">List</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#tlMenu" class="nav-link" data-bs-toggle="collapse" role="button">
                            Team Leader <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="tlMenu">
                            <li><a href="{{ route('tm.create') }}" class="nav-link">Create</a></li>
                            <li><a href="{{ route('tm.list') }}" class="nav-link">List</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#internMenu" class="nav-link" data-bs-toggle="collapse" role="button">
                            Intern <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="internMenu">
                            <li><a href="{{ route('intern.create') }}" class="nav-link">Create</a></li>
                            <li><a href="#" class="nav-link">List</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <a href="#" class="nav-link"><i class="bi bi-calendar-event me-3"></i>Attendance</a>
            <a href="#" class="nav-link"><i class="bi bi-file-earmark-text me-3"></i>Reports</a>
            <a href="#" class="nav-link"><i class="bi bi-gear me-3"></i>Settings</a>
        </div>
    </nav>

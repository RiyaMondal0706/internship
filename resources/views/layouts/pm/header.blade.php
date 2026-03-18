<style>
    .top-navbar {
        background: #ffffff;
        padding: 14px 25px;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .page-title {
        font-weight: 600;
        color: #1f2937;
    }

    .btn-toggle {
        border: none;
        background: transparent;
    }

    .icon-btn {
        border: none;
        background: #f3f4f6;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-btn:hover {
        background: #e5e7eb;
    }

    .notification-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        background: #ef4444;
        color: white;
        font-size: 10px;
        padding: 2px 5px;
        border-radius: 50%;
    }

    .profile-img {
        width: 38px;
        height: 38px;
    }

    .role-text {
        font-size: 12px;
    }
</style>

<header class="top-navbar d-flex justify-content-between align-items-center sticky-top">

    <!-- Left Section -->
    <div class="d-flex align-items-center">
        <button class="btn btn-toggle me-3 d-lg-none" id="sidebarToggle">
            <i class="bi bi-list fs-3"></i>
        </button>

        <h5 class="page-title mb-0">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </h5>
    </div>

    <!-- Right Section -->
    <div class="d-flex align-items-center gap-3">

        <!-- Notification -->
        <div class="dropdown">
            <button class="btn icon-btn position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell fs-5"></i>
                <span class="notification-badge">3</span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><a class="dropdown-item" href="#">New employee added</a></li>
                <li><a class="dropdown-item" href="#">Project assigned</a></li>
                <li><a class="dropdown-item" href="#">Report generated</a></li>
            </ul>
        </div>

        <!-- Profile -->
        <div class="dropdown">
            <a href="#" class="profile-menu d-flex align-items-center text-decoration-none"
                data-bs-toggle="dropdown">

                <div class="text-end me-2 d-none d-md-block">
                    <small class="fw-bold d-block">Project Manager User</small>
                    <small class="text-muted role-text">Project Manager</small>
                </div>

                <img src="https://ui-avatars.com/api/?name=Admin+User&background=4e73df&color=fff"
                    class="rounded-circle profile-img" alt="profile">

            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-person me-2"></i>Profile
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>

</header>

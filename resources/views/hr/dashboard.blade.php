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



        /* CARDS */

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.08);
        }

        /* CHART */

        .chart-container {
            position: relative;
            height: 280px;
        }

        /* MOBILE */

        @media(max-width:992px) {


            #main-content {
                margin-left: 0;
                width: 100%;
            }

        }
    </style>

</head>

<body>


    <!-- SIDEBAR -->
    @include('layouts.hr.sidebar')


    <!-- MAIN CONTENT -->

    <div id="main-content">


        <!-- HEADER -->

        @include('layouts.hr.header')


        <!-- CONTENT -->

        <div class="container-fluid p-4">


            <div class="row g-4 mb-4">

                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card p-4 border-start border-primary border-4">
                        <small class="text-primary fw-bold text-uppercase">Total Employees</small>
                        <h3 class="fw-bold mb-0">1,482</h3>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card p-4 border-start border-success border-4">
                        <small class="text-success fw-bold text-uppercase">Present Today</small>
                        <h3 class="fw-bold mb-0">94%</h3>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card p-4 border-start border-info border-4">
                        <small class="text-info fw-bold text-uppercase">New Candidates</small>
                        <h3 class="fw-bold mb-0">12</h3>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card p-4 border-start border-warning border-4">
                        <small class="text-warning fw-bold text-uppercase">Pending Leaves</small>
                        <h3 class="fw-bold mb-0">07</h3>
                    </div>
                </div>

            </div>



            <div class="row g-4 mb-4">

                <div class="col-lg-8">

                    <div class="card stat-card p-4">

                        <h6 class="fw-bold mb-4">Attendance by Department</h6>

                        <div class="chart-container">
                            <canvas id="deptChart"></canvas>
                        </div>

                    </div>

                </div>


                <div class="col-lg-4">

                    <div class="card stat-card p-4">

                        <h6 class="fw-bold mb-4">Employee Status</h6>

                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });


        new Chart(document.getElementById('deptChart'), {
            type: 'bar',
            data: {
                labels: ['IT', 'HR', 'Finance', 'Sales', 'Ops', 'Design'],
                datasets: [{
                    data: [98, 92, 85, 78, 90, 95],
                    backgroundColor: '#4e73df',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });


        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Full-time', 'Contract', 'Intern'],
                datasets: [{
                    data: [80, 15, 5],
                    backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</body>

</html>

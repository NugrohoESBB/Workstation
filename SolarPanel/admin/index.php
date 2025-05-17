<?php
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../index.php");
        exit();
    }

    $username = $_SESSION['username'];
    $role = $_SESSION['role'];

    $current_time = date('Ymd-His');

    $cookie_name = $role . '-' . $current_time;

    setcookie('custom_session', $cookie_name, time() + (30 * 24 * 60 * 60), '/');

    if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        setcookie('custom_session', '', time() - 3600, '/');

        header("Location: ../index.php");
        exit();
    }


    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'db_solarpanel';
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // CHART LOCATION
    $queryChart = "SELECT provinsi, COUNT(*) AS jumlah FROM data_irradiasi GROUP BY provinsi";
    $result = $conn->query($queryChart);

    $dataChart = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataChart[] = [
                'provinsi' => $row['provinsi'],
                'jumlah' => (int)$row['jumlah']
            ];
        }
    }

    // ============== DATA DASHBOARD ==============
    // USERS DATA
    $queryUser = "SELECT COUNT(*) as total_user FROM data_user";
    $resultUser = $conn->query($queryUser);
    $rowUser = $resultUser->fetch_assoc();
    $totalUser = $rowUser['total_user'];

    // LOCATIONS DATA
    $queryLokasi = "SELECT COUNT(*) as total_lokasi FROM data_irradiasi";
    $resultLokasi = $conn->query($queryLokasi);
    $rowLokasi = $resultLokasi->fetch_assoc();
    $totalLokasi = $rowLokasi['total_lokasi'];

    // RESULTS DATA
    $queryResult = "SELECT COUNT(*) as total_result FROM perhitungan";
    $resultResult = $conn->query($queryResult);
    $rowResult = $resultResult->fetch_assoc();
    $totalResult = $rowResult['total_result'];

    // DATA TABLES
    $sqlTable = "SELECT provinsi, kab_kota, irradiasi_bulanan, orientasi, kemiringan FROM data_irradiasi ORDER BY kab_kota ASC";
    $resultTable = $conn->query($sqlTable);

    $tableRows = "";
    if ($resultTable->num_rows > 0) {
        while ($rowTable = $resultTable->fetch_assoc()) {
            $tableRows .= "<tr>
                <td>{$rowTable['provinsi']}</td>
                <td>{$rowTable['kab_kota']}</td>
                <td>{$rowTable['irradiasi_bulanan']}</td>
                <td>{$rowTable['orientasi']}</td>
                <td>{$rowTable['kemiringan']}</td>
            </tr>";
        }
    } else {
        $tableRows = "<tr><td colspan='5'>Tidak ada data.</td></tr>";
    }

    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Solar Panel</title>

    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="dist/css/style.min.css" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">

                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>

                    <div class="navbar-brand">
                        <a href="index.php">
                            <b class="logo-icon">
                                <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                                <img src="assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                            </b>
                        </a>
                    </div>
                    
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto ml-3 pl-1"></ul>
                    
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="assets/images/users/profile-pic.jpg" alt="user" class="rounded-circle" width="40">
                                <span class="ml-2 d-none d-lg-inline-block">
                                    <span>Hello,</span>
                                    <span class="text-dark">Admin</span>
                                    <i data-feather="chevron-down" class="svg-icon"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="?logout=true">
                                    <i data-feather="power" class="svg-icon mr-2 ml-1"></i>Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="index.php" aria-expanded="false">
                            <i data-feather="home" class="feather-icon"></i>
                            <span class="hide-menu">Dashboard</span></a>
                        </li>

                        <li class="list-divider"></li>
                        <li class="nav-small-cap">
                            <span class="hide-menu">Applications</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="location.php" aria-expanded="false">
                                <i data-feather="tag" class="feather-icon"></i>
                                <span class="hide-menu">Locations Data</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="user.php" aria-expanded="false">
                                <i data-feather="tag" class="feather-icon"></i>
                                <span class="hide-menu">Users Data</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="result.php" aria-expanded="false">
                                <i data-feather="tag" class="feather-icon"></i>
                                <span class="hide-menu">Results Data</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">

                    <div class="col-7 align-self-center">
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Dashboard</h3>
                    </div>

                </div>
            </div>

            <div class="container-fluid">

                <div class="card-group">
                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <h2 class="text-dark mb-1 font-weight-medium"><?= $totalUser ?></h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Data User</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup class="set-doller">$</sup>18,306</h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Earnings of Month</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <h2 class="text-dark mb-1 font-weight-medium"><?= $totalResult ?></h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Data Result</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="file-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <h2 class="text-dark mb-1 font-weight-medium"><?= $totalLokasi ?></h2>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Data Lokasi</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="globe"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Locations Chart</h4>
                                <canvas id="chartLocation" class="mt-2"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-12 col-xxl-5 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Map of Locations</h4>
                                <div id="visitbylocate" style="height:100% width: 100%; min-height: 360px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <h4 class="card-title">Locations Data Table</h4>
                                </div>
                                <div class="table-responsive">
                                    <table id="tabel-irradiasi" class="table no-wrap v-middle mb-0">
                                        <thead>
                                            <tr class="border-0">
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Irradiasi Bulanan</th>
                                                <th>Orientasi</th>
                                                <th>Kemiringan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= $tableRows ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer text-center text-muted">
                <a href="index.php" class="text-muted"><strong>Copyright &copy; Nugroho Eko S Batubara</a> - <?= date("Y"); ?></strong></a>
            </footer>

        </div>
    </div>

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <script src="dist/js/custom.min.js"></script>
    <script src="assets/extra-libs/c3/d3.min.js"></script>
    <script src="assets/extra-libs/c3/c3.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        //DATA TABLES
        $(document).ready(function () {
            $('#tabel-irradiasi').DataTable({
                responsive: true,
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "searching": true
            });
        });

        // LOCATIONS MAPS
        var map = L.map('visitbylocate').setView([-2.5, 118], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        setTimeout(() => {
            map.invalidateSize();
        }, 300);


        // CHART LOCATIONS
        document.addEventListener("DOMContentLoaded", function () {
            const chartData = <?= json_encode($dataChart); ?>;
            const labels = chartData.map(item => item.provinsi);
            const data = chartData.map(item => item.jumlah);

            const colors = [
                '#A2DFF7',
                '#FFB3B3',
                '#C9F7B5',
                '#FFEC99',
                '#D1C4E9',
                '#F7D1D1'
            ];

            // Konfigurasi chart dengan Chart.js
            const ctx = document.getElementById('chartLocation').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        hoverBackgroundColor: colors.map(color => lightenColor(color, 0.3)),
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ": " + tooltipItem.raw;
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: false,
                    },
                    hover: {
                        onHover: function(e) {
                            const chart = e.chart;
                            const activePoint = chart.getElementsAtEventForMode(e, 'nearest', { intersect: false }, true);
                            
                            chart.data.datasets.forEach((dataset, i) => {
                                dataset.backgroundColor = dataset.backgroundColor.map((color, index) => {
                                    if (activePoint.length > 0 && index === activePoint[0].index) {
                                        return lightenColor(color, 0.3);
                                    } else {
                                        return 'rgba(0, 0, 0, 0.1)';
                                    }
                                });
                            });
                            chart.update();
                        }
                    }
                }
            });

            function lightenColor(color, percent) {
                let R = parseInt(color.substring(1, 3), 16);
                let G = parseInt(color.substring(3, 5), 16);
                let B = parseInt(color.substring(5, 7), 16);
                
                R = Math.round(R + (255 - R) * percent);
                G = Math.round(G + (255 - G) * percent);
                B = Math.round(B + (255 - B) * percent);

                return `rgb(${R},${G},${B})`;
            }
        });
    </script>

</body>
</html>

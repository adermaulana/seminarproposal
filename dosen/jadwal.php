<?php

include '../koneksi.php';

session_start();

$nip_dosen = $_SESSION['nip'];

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../assets/images/favicon.ico" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav me-lg-2">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img src="../assets/images/faces/face5.jpg" alt="profile"/>
              <span class="nav-profile-name"><?= $_SESSION['nama_dosen'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="logout.php">
                <i class="typcn typcn-eject text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">      
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>                                    
          <li class="nav-item">
            <a class="nav-link" href="jadwal.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Jadwal Seminar</span>
            </a>
          </li>                                                                      
          <li class="nav-item">
            <a class="nav-link" href="laporan.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Laporan</span>
            </a>
          </li>                                    
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="typcn typcn-mortar-board menu-icon"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Seminar</h4>
                            <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Program Studi</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Ruangan</th>
                                        <th>Pembimbing</th>
                                        <th>Penguji</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                $tampil = mysqli_query($koneksi, "
                                    SELECT s.*, p.judul, p.nim, m.nama AS nama_mahasiswa, m.jurusan 
                                    FROM seminar s
                                    JOIN proposal p ON s.proposal_id = p.id
                                    JOIN mahasiswa m ON p.nim = m.nim
                                    WHERE p.id IN (
                                        SELECT proposal_id 
                                        FROM pembimbing 
                                        WHERE nip = '$nip_dosen'
                                    )
                                    OR s.id IN (
                                        SELECT seminar_id
                                        FROM penguji
                                        WHERE nip = '$nip_dosen'
                                    )
                                    ORDER BY s.tanggal DESC, s.waktu DESC
                                ");

                                while($data = mysqli_fetch_array($tampil)):
                                    // Query untuk mendapatkan pembimbing
                                    $pembimbing_query = mysqli_query($koneksi, "
                                        SELECT d.nama, pb.status
                                        FROM pembimbing pb
                                        JOIN dosen d ON pb.nip = d.nip
                                        WHERE pb.proposal_id = '$data[proposal_id]'
                                        ORDER BY pb.status
                                    ");

                                    // Query untuk mendapatkan penguji
                                    $penguji_query = mysqli_query($koneksi, "
                                        SELECT d.nama 
                                        FROM penguji p
                                        JOIN dosen d ON p.nip = d.nip
                                        WHERE p.seminar_id = '$data[id]'
                                    ");
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['nim'] ?></td>
                                        <td><?= $data['nama_mahasiswa'] ?></td>
                                        <td><?= $data['jurusan'] ?></td>
                                        <td><?= $data['judul'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
                                        <td><?= date('H:i', strtotime($data['waktu'])) ?></td>
                                        <td><?= $data['ruangan'] ?></td>
                                        <td>
                                            <?php 
                                            while($pembimbing = mysqli_fetch_array($pembimbing_query)) {
                                                echo $pembimbing['nama'] . ' (' . $pembimbing['status'] . ')<br>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            $i = 1;
                                            while($penguji = mysqli_fetch_array($penguji_query)) {
                                                echo 'Penguji ' . $i . ': ' . $penguji['nama'] . '<br>';
                                                $i++;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $data['status'];
                                            $badge_color = '';
                                            switch($status) {
                                                case 'Dijadwalkan':
                                                    $badge_color = 'primary';
                                                    break;
                                                case 'Selesai':
                                                    $badge_color = 'success';
                                                    break;
                                                case 'Dibatalkan':
                                                    $badge_color = 'danger';
                                                    break;
                                                case 'Ditunda':
                                                    $badge_color = 'warning';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge badge-<?= $badge_color ?>"><?= $status ?></span>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../assets/vendors/chart.js/chart.umd.js"></script>
  <script src="../assets/js/jquery.cookie.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/template.js"></script>
  <script src="../assets/js/settings.js"></script>
  <script src="../assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../assets/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>


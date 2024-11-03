<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login'){

    session_unset();
    session_destroy();

    header("location:../");

}

if(isset($_GET['hal']) == "hapus"){

  $hapus = mysqli_query($koneksi, "DELETE FROM proposal WHERE id = '$_GET[id]'");

  if($hapus){
      echo "<script>
      alert('Hapus data sukses!');
      document.location='mahasiswa.php';
      </script>";
  }
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
              <span class="nav-profile-name"><?= $_SESSION['nama_admin'] ?></span>
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
            <a class="nav-link" href="mahasiswa.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Mahasiswa</span>
            </a>
          </li>                                    
          <li class="nav-item">
            <a class="nav-link" href="dosen.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dosen</span>
            </a>
          </li>                                    
          <li class="nav-item">
            <a class="nav-link" href="proposal.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Proposal</span>
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
                            <h4 class="card-title">Data Proposal</h4>
                            <a class="btn btn-success mb-2" href="tambahproposal.php">Ajukan Proposal</a>
                            <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Program Studi</th>
                                        <th>Judul</th>
                                        <th>File</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $tampil = mysqli_query($koneksi, "SELECT p.*, m.nama AS nama_mahasiswa, m.jurusan 
                                                                    FROM proposal p 
                                                                    JOIN mahasiswa m ON p.nim = m.nim 
                                                                    ORDER BY p.tanggal_pengajuan DESC");
                                    while($data = mysqli_fetch_array($tampil)):
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['nim'] ?></td>
                                        <td><?= $data['nama_mahasiswa'] ?></td>
                                        <td><?= $data['jurusan'] ?></td>
                                        <td><?= $data['judul'] ?></td>
                                        <td>
                                            <a href="uploads/proposal/<?= $data['file_proposal'] ?>" 
                                            class="btn btn-info btn-sm" target="_blank">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </td>
                                        <td><?= date('d-m-Y H:i', strtotime($data['tanggal_pengajuan'])) ?></td>
                                        <td>
                                            <?php
                                            $status = $data['status'];
                                            $badge_color = '';
                                            switch($status) {
                                                case 'Menunggu Persetujuan':
                                                    $badge_color = 'warning';
                                                    break;
                                                case 'Disetujui':
                                                    $badge_color = 'success';
                                                    break;
                                                case 'Ditolak':
                                                    $badge_color = 'danger';
                                                    break;
                                                case 'Revisi':
                                                    $badge_color = 'info';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge badge-<?= $badge_color ?>"><?= $status ?></span>
                                        </td>
                                        <td>
                                            <?php if($data['status'] == 'Menunggu Persetujuan'): ?>
                                            <a class="btn btn-success btn-sm" 
                                            href="proses_setuju.php?id=<?= $data['id'] ?>" 
                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui proposal ini?')">
                                                <i class="fas fa-check"></i> Setujui
                                            </a>
                                            <a class="btn btn-secondary btn-sm" 
                                            href="proses_tolak.php?id=<?= $data['id'] ?>" 
                                            onclick="return confirm('Apakah Anda yakin ingin menolak proposal ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </a>
                                            <a class="btn btn-info btn-sm" 
                                            href="proses_revisi.php?id=<?= $data['id'] ?>" 
                                            onclick="return confirm('Apakah Anda yakin ingin meminta revisi proposal ini?')">
                                                <i class="fas fa-redo"></i> Revisi
                                            </a>
                                            <?php endif; ?>
                                            <a class="btn btn-danger btn-sm" 
                                            href="hapusproposal.php?id=<?= $data['id'] ?>" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus proposal ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
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


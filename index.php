<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

    if(isset($_POST['login'])) {
        // Sanitasi input
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $nim = isset($_POST['nim']) ? mysqli_real_escape_string($koneksi, $_POST['nim']) : '';
        $nip = isset($_POST['nip']) ? mysqli_real_escape_string($koneksi, $_POST['nip']) : '';
        $password = md5($_POST['password']); // Tetap menggunakan MD5 sesuai sistem yang ada
    
        // Query dengan prepared statement untuk admin
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM admin WHERE username=? AND password=?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $login = mysqli_stmt_get_result($stmt);
        $cek = mysqli_num_rows($login);
    
        // Query dengan prepared statement untuk mahasiswa
        $stmtMhs = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa WHERE nim=? AND password=?");
        mysqli_stmt_bind_param($stmtMhs, "ss", $nim, $password);
        mysqli_stmt_execute($stmtMhs);
        $loginMahasiswa = mysqli_stmt_get_result($stmtMhs);
        $cekMahasiswa = mysqli_num_rows($loginMahasiswa);
    
        // Query dengan prepared statement untuk dosen
        $stmtDosen = mysqli_prepare($koneksi, "SELECT * FROM dosen WHERE nip=? AND password=?");
        mysqli_stmt_bind_param($stmtDosen, "ss", $nip, $password);
        mysqli_stmt_execute($stmtDosen);
        $loginDosen = mysqli_stmt_get_result($stmtDosen);
        $cekDosen = mysqli_num_rows($loginDosen);
    
        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['id_admin'] = $admin_data['id'];
            $_SESSION['nama_admin'] = $admin_data['nama'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            $_SESSION['role'] = "admin";
            header('location:admin');
            exit();
    
        } else if($cekMahasiswa > 0) {
            $mhs_data = mysqli_fetch_assoc($loginMahasiswa);
            $_SESSION['id_mahasiswa'] = $mhs_data['id'];
            $_SESSION['nama_mahasiswa'] = $mhs_data['nama'];
            $_SESSION['nim'] = $mhs_data['nim'];
            $_SESSION['status'] = "login";
            $_SESSION['role'] = "mahasiswa";
            header('location:mahasiswa');
            exit();
    
        } else if($cekDosen > 0) {
            $dosen_data = mysqli_fetch_assoc($loginDosen);
            $_SESSION['id_dosen'] = $dosen_data['id'];
            $_SESSION['nama_dosen'] = $dosen_data['nama'];
            $_SESSION['nip'] = $dosen_data['nip'];
            $_SESSION['status'] = "login";
            $_SESSION['role'] = "dosen";
            header('location:dosen');
            exit();
    
        } else {
            echo "<script>
                alert('Login Gagal, Periksa Username dan Password Anda!');
                window.location.href='index.php';
            </script>";
            exit();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/login/css/bootstrap.min.css">
    <title>Login</title>

</head>
<body>

<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <form method="post">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-5 mt-3">Sign in</h3>

                            <!-- Pilihan Role -->
                            <div class="form-outline mb-4">
                                <label class="form-label">Login Sebagai</label>
                                <select class="form-control form-control-lg" id="roleSelect" onchange="showFields()">
                                    <option value="admin">Admin</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="dosen">Dosen</option>
                                </select>
                            </div>

                            <!-- Field Username untuk Admin -->
                            <div id="usernameField" class="form-outline mb-4">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control form-control-lg" />
                            </div>

                            <!-- Field NIM untuk Mahasiswa -->
                            <div id="nimField" class="form-outline mb-4" style="display:none;">
                                <label class="form-label" for="nim">NIM</label>
                                <input type="text" id="nim" name="nim" class="form-control form-control-lg" />
                            </div>

                            <!-- Field NIP untuk Dosen -->
                            <div id="nipField" class="form-outline mb-4" style="display:none;">
                                <label class="form-label" for="nip">NIP</label>
                                <input type="text" id="nip" name="nip" class="form-control form-control-lg" />
                            </div>

                            <!-- Field Password -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control form-control-lg" />
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk menangani tampilan field berdasarkan role -->
    <script>
        function showFields() {
            const role = document.getElementById('roleSelect').value;
            const usernameField = document.getElementById('usernameField');
            const nimField = document.getElementById('nimField');
            const nipField = document.getElementById('nipField');

            // Sembunyikan semua field
            usernameField.style.display = 'none';
            nimField.style.display = 'none';
            nipField.style.display = 'none';

            // Tampilkan field sesuai role
            switch(role) {
                case 'admin':
                    usernameField.style.display = 'block';
                    break;
                case 'mahasiswa':
                    nimField.style.display = 'block';
                    break;
                case 'dosen':
                    nipField.style.display = 'block';
                    break;
            }
        }

        // Jalankan saat halaman dimuat
        window.onload = showFields;
    </script>
</section>

    <script src="assets/login/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:admin");
    }

    if(isset($_POST['login'])){

        $nim = $_POST['nim'];
        $password = md5($_POST['password']);

        $login = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim='$nim' and password='$password'");
        $cek = mysqli_num_rows($login);

        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['nim'] = $admin_data['nim'];
            $_SESSION['nama_mahasiswa'] = $admin_data['nama'];
            $_SESSION['username_mahasiswa'] = $username;
            $_SESSION['status'] = "login";
            header('location:mahasiswa');

        }  else {
            echo "<script>
            alert('Login Gagal, Periksa Username dan Password Anda!');
            header('location:index.php');
                 </script>";
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

    <style>



    </style>

</head>
<body>

    <section class="vh-100" style="background-color: #508bfc;">

    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <form method="post">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
                <a class="btn btn-success btn-lg btn-block" href="index.php">Admin</a>
                <a class="btn btn-primary btn-lg btn-block" href="logindosen.php">Dosen</a>

                <h3 class="mb-5 mt-3">Sign in</h3>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="nim">Nim</label>
                <input type="text" id="nim" name="nim" class="form-control form-control-lg" />
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" />
                </div>


                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>


            </div>
            </div>
        </form>

        </div>
        </div>
    </div>
    </section>

    <script src="assets/login/js/bootstrap.bundle.min.js"></script>

</body>
</html>
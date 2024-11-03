<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update status proposal menjadi Revisi
    $query = mysqli_query($koneksi, "UPDATE seminar SET status = 'Dijadwalkan' WHERE id = '$id'");
    
    if($query) {
        echo "<script>
            alert('Berhasil menjadwalkan ulang!');
            document.location='jadwal.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menjadwalkan ulang!');
            document.location='jadwal.php';
        </script>";
    }
}
?>
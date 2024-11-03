<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update status proposal menjadi Disetujui
    $query = mysqli_query($koneksi, "UPDATE seminar SET status = 'Selesai' WHERE id = '$id'");
    
    if($query) {
        echo "<script>
            alert('Seminar berhasil disetujui!');
            document.location='jadwal.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyetujui seminar!');
            document.location='jadwal.php';
        </script>";
    }
}
?>
<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Update status proposal menjadi Disetujui
    $query = mysqli_query($koneksi, "UPDATE proposal SET status = 'Disetujui' WHERE id = '$id'");
    
    if($query) {
        echo "<script>
            alert('Proposal berhasil disetujui!');
            document.location='proposal.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyetujui proposal!');
            document.location='proposal.php';
        </script>";
    }
}
?>
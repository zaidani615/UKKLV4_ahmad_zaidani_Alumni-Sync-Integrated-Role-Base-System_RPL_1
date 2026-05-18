<?php
session_start(); 
include 'koneksi.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit; 
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']); 
    $data = mysqli_query($koneksi, "SELECT * FROM alumni WHERE id_alumni='$id'");
    $d = mysqli_fetch_assoc($data);
    if (!$d) {
        header("Location: dashboard_admin.php");
        exit;
    }
} else {
    header("Location: dashboard_admin.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $nama_lama = $d['nama'];
    $query_alumni = "UPDATE alumni SET 
                        nama='$nama', 
                        angkatan='$angkatan', 
                        jurusan='$jurusan' 
                     WHERE id_alumni='$id'";
    
    if (mysqli_query($koneksi, $query_alumni)) {
        $query_users = "UPDATE users SET username='$nama' WHERE username='$nama_lama'";
        mysqli_query($koneksi, $query_users);
        echo "<script>
                alert('Data alumni & akun login berhasil diperbarui!'); 
                window.location.href='dashboard_admin.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data alumni!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alumni - Alumni Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/edit.css">
</head>
<body>

    <div class="box">
        <h2>Edit Data Alumni</h2>
        
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="nama" value="<?= htmlspecialchars($d['nama'] ?? '') ?>" placeholder="Nama Lengkap" required>
            </div>

            <div class="input-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="number" name="angkatan" value="<?= htmlspecialchars($d['angkatan'] ?? '') ?>" min="2000" max="2100" placeholder="Tahun Angkatan" required>
            </div>

            <div class="input-group">
                <i class="fas fa-graduation-cap"></i>
                <select name="jurusan" required>
                    <option value="Rekayasa Perangkat Lunak" <?= ($d['jurusan'] == "Rekayasa Perangkat Lunak") ? "selected" : "" ?>>
                        Rekayasa Perangkat Lunak
                    </option>
                    <option value="Teknik Komputer dan Jaringan" <?= ($d['jurusan'] == "Teknik Komputer dan Jaringan") ? "selected" : "" ?>>
                        Teknik Komputer dan Jaringan
                    </option>
                    <option value="Animasi" <?= ($d['jurusan'] == "Animasi") ? "selected" : "" ?>>
                        Animasi
                    </option>
                    <option value="Teknik Jaringan Akses Telekomunikasi" <?= ($d['jurusan'] == "Teknik Jaringan Akses Telekomunikasi") ? "selected" : "" ?>>
                        Teknik Jaringan Akses Telekomunikasi
                    </option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" name="update" class="btn-simpan">Simpan Perubahan</button>
                <a href="dashboard_admin.php" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>
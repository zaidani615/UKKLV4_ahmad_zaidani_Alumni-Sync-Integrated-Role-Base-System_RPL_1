<?php
session_start();
include 'koneksi.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit; 
}

$nama_admin = $_SESSION['username']; 
$no = 1;

if (isset($_GET['cari']) && $_GET['cari'] != '') {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']); 
    
    $query_alumni = "SELECT * FROM alumni WHERE nama LIKE '%$cari%' ORDER BY nama ASC";
} else {
    $query_layout = "";
    $query_alumni = "SELECT * FROM alumni ORDER BY nama ASC";
}
$data = mysqli_query($koneksi, $query_alumni);
$hitung_total = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM alumni");
$row_total    = mysqli_fetch_assoc($hitung_total);
$total_alumni = $row_total['total'];

$mode_detail = (isset($_GET['cari']) && mysqli_num_rows($data) == 1);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> 
    <title>Dashboard Admin - Manajemen Alumni</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/dashboard.css">
</head>
<body>

<div class="main-wrapper"> 
    <header>
        <div class="nav-container">
            <div class="nav-left">
                <div class="role-badge">ADMIN</div>
                <div class="school-name">TELKOM SCHOOL</div>
            </div>
            
            <div class="nav-center">
                <h2>MANAJEMEN DATA ALUMNI</h2>
            </div>
            
            <div class="nav-right">
                <div class="user-info">
                    <span>Selamat Datang,</span>
                    <strong><?= htmlspecialchars($nama_admin) ?></strong>
                </div>
                <a class="logout" href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="card"> 
            
            <div class="card-header">
                <div>
                    <h3>Daftar Alumni</h3>
                    <p>Total Alumni: <strong><?= $total_alumni; ?></strong></p> 
                </div>
                <div class="header-actions">
                    <a class="tambah" href="tambah.php">+ Tambah Data</a>
                    
                    <form action="" method="GET" class="search-container">
                        <input type="text" name="cari" placeholder="Search nama..." class="search-input" value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search"></i> 
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-responsive"> 
                <?php if (!$mode_detail): ?>
                <table>
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Jurusan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($data) > 0): ?> 
                            <?php while ($d = mysqli_fetch_array($data)): ?> 
                            <tr>
                                <td class="text-center"><?= $no++ ?></td> 
                                <td>
                                    <div class="name-column">
                                        <div class="avatar">
                                            <?= strtoupper(substr($d['nama'], 0, 1)) ?>
                                        </div>
                                        <span>
                                            <a href="?cari=<?= urlencode($d['nama']) ?>" class="name-link">
                                                <?= htmlspecialchars($d['nama']) ?>
                                            </a>
                                        </span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($d['angkatan']) ?></td>
                                <td><?= htmlspecialchars($d['jurusan']) ?></td>
                                <td class="aksi-container">
                                    <a href="edit.php?id=<?= $d['id_alumni'] ?>" class="btn-aksi" title="Edit Data">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="ganti_password.php?nama=<?= urlencode($d['nama']) ?>" class="btn-aksi" title="Ganti Password Akun">
                                        <i class="fas fa-key"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $d['id_alumni'] ?>" class="btn-aksi" onclick="return confirm('Apakah anda yakin ingin menghapus data alumni ini?')" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-row">Data tidak ditemukan di sistem.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php endif; ?>

                <?php 
                if ($mode_detail) {
                    mysqli_data_seek($data, 0); 
                    $d_detail = mysqli_fetch_assoc($data); 
                ?>
                <div class="profile-card-highlight">
                    <div class="card-content">
                        <div class="avatar-large">
                            <?= strtoupper(substr($d_detail['nama'], 0, 1)) ?>
                        </div>

                        <div class="detail-info" style="flex: 1;">
                            <div class="profile-header-flex">
                                <h4><i class="fas fa-id-card"></i> Detail Profil: <?= htmlspecialchars($d_detail['nama']) ?></h4>
                                <a href="cetak_profil.php?id=<?= $d_detail['id_alumni'] ?>" class="btn-cetak" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Cetak PDF
                                </a>
                            </div>

                            <div class="grid-detail-admin">
                                <div class="column-admin">
                                    <div class="info-item">
                                        <strong><i class="fab fa-whatsapp"></i> Nomor WhatsApp:</strong>
                                        <span>
                                            <?php if (!empty($d_detail['telepon'])): ?>
                                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $d_detail['telepon']) ?>" target="_blank" class="icon-wa" style="text-decoration: none;">
                                                    <?= htmlspecialchars($d_detail['telepon']) ?>
                                                </a>
                                            <?php else: ?> - <?php endif; ?>
                                        </span>
                                    </div>

                                    <div class="info-item">
                                        <strong><i class="fas fa-envelope"></i> Alamat Email:</strong>
                                        <span><?= !empty($d_detail['email']) ? htmlspecialchars($d_detail['email']) : '-' ?></span>
                                    </div>

                                    <div class="info-item">
                                        <strong><i class="fab fa-instagram"></i> Media Sosial (IG):</strong>
                                        <span>
                                            <?php if (!empty($d_detail['instagram'])): ?>
                                                <a href="https://instagram.com/<?= ltrim($d_detail['instagram'], '@') ?>" target="_blank" class="icon-ig" style="text-decoration: none;">
                                                    <?= '@' . htmlspecialchars(ltrim($d_detail['instagram'], '@')) ?>
                                                </a>
                                            <?php else: ?> - <?php endif; ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="column-admin">
                                    <div class="info-item">
                                        <strong><i class="fas fa-briefcase"></i> Status & Instansi:</strong>
                                        <span>
                                            <?= !empty($d_detail['status_alumni']) ? htmlspecialchars($d_detail['status_alumni']) : '-' ?> 
                                            <?php if (!empty($d_detail['tempat_kerja'])): ?>
                                                 <strong><?= htmlspecialchars($d_detail['tempat_kerja']) ?></strong>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <strong><i class="fas fa-map-marker-alt"></i> Alamat Domisili:</strong>
                                        <span><?= !empty($d_detail['alamat']) ? htmlspecialchars($d_detail['alamat']) : 'Belum mengisi alamat.' ?></span>
                                    </div>

                                    <div style="margin-top: 15px;">
                                        <a href="dashboard_admin.php" class="btn-back-admin">
                                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Utama
                                        </a>
                                    </div>
                                </div>
                            </div> </div> </div> </div> <?php } ?>
            </div> </div> </div> <footer>
        &copy; <?= date('Y') ?> Ahmad Zaidani - All Rights Reserved 
    </footer>
</div> 

</body>
</html>
<?php
require_once("koneksi.php");

//ambil data penumpang dari file yang berbeda
$penumpang = $db->query("SELECT * FROM penumpang");

// mengambil data jadwal dari file yang berbeda dan tidak semua data diambil
$jadwal = $db->query("SELECT jadwal.id_jadwal, jadwal.tanggal, jadwal.harga, kereta.nama_kereta
                      FROM jadwal
                      JOIN kereta ON jadwal.id_kereta = kereta.id_kereta");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pemesanan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Pesan Tiket</h2>
        <form method="post">
           <label for="">Pilih Penumpang</label>
           <select name="id_penumpang" required>
            <?php while ($data = $penumpang->fetch_assoc()) { ?>
                <option value="<?= $data['id_penumpang']; ?>">
                    <?= $data['nama']; ?> (<?= $data['email']; ?>)
                </option>
            <?php } ?>
           </select><br>

           <label for="">Pilih Jadwal</label>
           <select name="id_jadwal" required>
            <?php while ($data_jadwal = $jadwal->fetch_assoc()) { ?>
                <option value="<?= $data_jadwal['id_jadwal']; ?>">
                    <?= $data_jadwal['nama_kereta']; ?> - 
                    <?= $data_jadwal['tanggal']; ?> 
                    (Rp <?= number_format($data_jadwal['harga'],0,',','.');?>)
                </option>
            <?php } ?>
           </select><br>

            <label for="">Jumlah Tiket</label>
            <input type="number" name="jumlah_tiket" min="1" required><br>

            <button type="submit" name="pesan">Pesan</button>
        </form>

        <?php
        if (isset($_POST['pesan'])) {
            //membuat agar inputan sesuai dengan tipe data
            $id_penumpang = $db->real_escape_string($_POST['id_penumpang']);
            $id_jadwal    = $db->real_escape_string($_POST['id_jadwal']);
            $jumlah_tiket = (int) $_POST['jumlah_tiket'];

            //mengambil jumlah harga dari jadwal
            $result = $db->query("SELECT harga FROM jadwal WHERE id_jadwal='$id_jadwal'");
            if ($result && $harga = $result->fetch_assoc()) {
                $total = $jumlah_tiket * $harga['harga'];

                //memasukkan hasil dari smeua data ke pemesanan
                $sql = "INSERT INTO pemesanan (id_penumpang, id_jadwal, jumlah_tiket, total_harga, status)
                        VALUES ('$id_penumpang', '$id_jadwal', '$jumlah_tiket', '$total', 'Menunggu Pembayaran')";

                if ($db->query($sql)) {
                    echo "<p style='color:green;'>Pemesanan berhasil! Total harga: Rp " . number_format($total,0,',','.') . "</p>";
                } else {
                    echo "<p style='color:red;'>Terjadi kesalahan: " . $db->error . "</p>";
                }
            } 
        }
        ?>
    </div>
</body>
</html>

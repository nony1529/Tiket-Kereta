<?php
require_once("koneksi.php");

// Variabel untuk menampung data
$id_jadwal     = "";
$tanggal       = "";
$jam_berangkat = "";
$jam_tiba      = "";
$harga         = "";
$nameBtn       = "input";
$valueBtn      = "Submit";

// Mengambil data dari tabel lain
$kereta   = $db->query("SELECT * FROM kereta");

//mengambil data stasiun asal dan stasiun tujuan
$stasiun  = $db->query("SELECT * FROM stasiun");
$stasiun2 = $db->query("SELECT * FROM stasiun");

// Function untuk input data jadwal
function inputData($db) {
    $sql = "INSERT INTO jadwal 
        (id_kereta, id_stasiun_asal, id_stasiun_tujuan, tanggal, jam_berangkat, jam_tiba, harga)
        VALUES (
            '" . $_POST['id_kereta'] . "',
            '" . $_POST['id_stasiun_asal'] . "',
            '" . $_POST['id_stasiun_tujuan'] . "',
            '" . $_POST['tanggal'] . "',
            '" . $_POST['jam_berangkat'] . "',
            '" . $_POST['jam_tiba'] . "',
            '" . $_POST['harga'] . "'
        )";
    mysqli_query($db, $sql) or die("Gagal Input: " . mysqli_error($db));
}

// Function untuk update data jadwal
function updateData($db) {
    mysqli_query($db, "UPDATE jadwal SET
        tanggal = '" . $_POST['tanggal'] . "',
        jam_berangkat = '" . $_POST['jam_berangkat'] . "',
        jam_tiba = '" . $_POST['jam_tiba'] . "',
        harga = '" . $_POST['harga'] . "'
        WHERE id_jadwal = '" . $_POST['id_jadwal'] . "'
    ") or die("Gagal Update: " . mysqli_error($db));
    header('location:jadwal.php');
    exit;
}

// Function untuk hapus data jadwal
function deleteData($db, $id_jadwal) {
    mysqli_query($db, "DELETE FROM jadwal WHERE id_jadwal='$id_jadwal'") or die("Gagal Hapus: " . mysqli_error($db));
    header('location:jadwal.php');
    exit;
}

// Function untuk ambil data edit
function getEditData($db, $id_jadwal) {
    $result = mysqli_query($db, "SELECT * FROM jadwal WHERE id_jadwal='$id_jadwal'") or die("Gagal Mengambil Data: " . mysqli_error($db));
    return mysqli_fetch_array($result);
}

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['submit'] === 'input') {
        inputData($db);
    } elseif ($_POST['submit'] === 'update') {
        updateData($db);
    }
}

// Proses aksi edit/hapus
if (isset($_GET['act'])) {
    if ($_GET['act'] === 'hapus') {
        deleteData($db, $_GET['id_jadwal']);
    } elseif ($_GET['act'] === 'edit') {
        $data = getEditData($db, $_GET['id_jadwal']);
        $id_jadwal     = $data['id_jadwal'];
        $tanggal       = $data['tanggal'];
        $jam_berangkat = $data['jam_berangkat'];
        $jam_tiba      = $data['jam_tiba'];
        $harga         = $data['harga'];
        $nameBtn       = "update";
        $valueBtn      = "Update";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Jadwal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Mengatur Jadwal</h2>
    <form method="post">
        <input type="hidden" name="id_jadwal" value="<?php echo $id_jadwal ?>">

        <div>
            <label>Kereta</label>
            <select name="id_kereta" required>
                <?php while ($k = $kereta->fetch_assoc()) { ?>
                    <option value="<?= $k['id_kereta']; ?>"><?= $k['nama_kereta']; ?> (<?= $k['kelas']; ?>)</option>
                <?php } ?>
            </select>
        </div>

        <div>
            <label>Stasiun Asal</label>
            <select name="id_stasiun_asal" required>
                <?php while ($s = $stasiun->fetch_assoc()) { ?>
                    <option value="<?= $s['id_stasiun']; ?>">
                        <?= $s['nama_stasiun']; ?> (<?= $s['kota']; ?>)
                    </option>
                <?php } ?>
            </select>
        </div>

        <div>
            <label>Stasiun Tujuan</label>
            <select name="id_stasiun_tujuan" required>
                <?php while ($s = $stasiun2->fetch_assoc()) { ?>
                    <option value="<?= $s['id_stasiun']; ?>">
                        <?= $s['nama_stasiun']; ?> (<?= $s['kota']; ?>)
                    </option>
                <?php } ?>
            </select>
        </div>

        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?php echo $tanggal ?>" required>

        <label>Jam Berangkat</label>
        <input type="time" name="jam_berangkat" value="<?php echo $jam_berangkat ?>" required>

        <label>Jam Tiba</label>
        <input type="time" name="jam_tiba" value="<?php echo $jam_tiba ?>" required>

        <label>Harga</label>
        <input type="number" name="harga" value="<?php echo $harga ?>" required>

        <button type="submit" name="submit" value="<?php echo $nameBtn ?>"><?php echo $valueBtn ?></button>
    </form>

    <h2>Data Jadwal</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam Berangkat</th>
            <th>Jam Tiba</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($db, "SELECT * FROM jadwal ORDER BY id_jadwal DESC");
        $no = 1;
        while ($data = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".htmlspecialchars($data['tanggal'])."</td>";
            echo "<td>".htmlspecialchars($data['jam_berangkat'])."</td>";
            echo "<td>".htmlspecialchars($data['jam_tiba'])."</td>";
            echo "<td>".htmlspecialchars($data['harga'])."</td>";
            echo "<td class='aksi'>
                    <a href='?act=edit&id_jadwal=".$data['id_jadwal']."'>Edit</a>
                    <a href='?act=hapus&id_jadwal=".$data['id_jadwal']."' onclick='return confirm(\"Yakin ingin hapus?\")'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>

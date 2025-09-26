<?php
require_once("koneksi.php");

//variabel untuk menampung data
$id_kereta = "";
$nama_kereta = "";
$kelas = "";
$jumlah_kursi = "";
$nameBtn = "input"; 
$valueBtn = "Submit";

//function untuk menginput data kereta
function inputData($db) {
    mysqli_query($db, "INSERT INTO kereta (nama_kereta, kelas, jumlah_kursi)
        VALUES(
            '" . $_POST['nama_kereta'] . "',
            '" . $_POST['kelas'] . "',
            '" . $_POST['jumlah_kursi'] . "'
        )") or die("Gagal Input");
}

//function untuk mengupdate data kereta
function updateData($db) {
    mysqli_query($db, "UPDATE kereta SET
        nama_kereta = '" . $_POST['nama_kereta'] . "',
        kelas = '" . $_POST['kelas'] . "',
        jumlah_kursi = '" . $_POST['jumlah_kursi'] . "'
        WHERE id_kereta = '" . $_POST['id_kereta'] . "'
    ") or die("Gagal Update");

    header('location:kereta.php');
}

//function untuk menghapus data kereta
function deleteData($db, $id_kereta) {
    mysqli_query($db, "DELETE FROM kereta WHERE id_kereta='$id_kereta'") or die("Gagal Hapus");
    header('location:kereta.php');
}

//function untuk mengambil dan mengedit data kereta
function getEditData($db, $id_kereta) {
    $result = mysqli_query($db, "SELECT * FROM kereta WHERE id_kereta='$id_kereta'") or die("Gagal Mengambil Data");
    return mysqli_fetch_array($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['submit'] === 'input') {
        inputData($db);
    } elseif ($_POST['submit'] === 'update') {
        updateData($db);
    }
}

if (isset($_GET['act'])) {
    if ($_GET['act'] === 'hapus') {
        deleteData($db, $_GET['id_kereta']);
    } elseif ($_GET['act'] === 'edit') {
        $data = getEditData($db, $_GET['id_kereta']);
        $id_kereta = $data['id_kereta'];
        $nama_kereta = $data['nama_kereta'];
        $kelas = $data['kelas'];
        $jumlah_kursi = $data['jumlah_kursi'];
        $nameBtn = "update";
        $valueBtn = "Update";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data kereta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Kereta</h2>
        <form method="post">
            <input type="hidden" name="id_kereta" value="<?php echo $id_kereta ?>">

            <label>Nama Kereta</label>
            <input type="text" name="nama_kereta" value="<?php echo $nama_kereta ?>" >

            <label>Kelas</label>
            <input type="text" name="kelas" value="<?php echo $kelas ?>" >

            <label>Jumlah Kursi</label>
            <input type="text" name="jumlah_kursi" value="<?php echo $jumlah_kursi ?>" >

            <button type="submit" name="submit" value="<?php echo $nameBtn ?>"><?php echo $valueBtn ?></button>
        </form>

        <h2>Data Kereta</h2>
        <table>
            <tr>
                <th>No</th>
                <th>nama_kereta</th>
                <th>kelas</th>
                <th>Jumlah Kursi</th>
                <th>Aksi</th>
            </tr>
            <?php
            $query = mysqli_query($db, "SELECT * FROM kereta ORDER BY id_kereta DESC");
            $no = 1;
            while ($data = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($data['nama_kereta'])."</td>";
                echo "<td>".htmlspecialchars($data['kelas'])."</td>";
                echo "<td>".htmlspecialchars($data['jumlah_kursi'])."</td>";
                echo "<td class='aksi'>
                        <a href='?act=edit&id_kereta=".$data['id_kereta']."'>Edit</a>
                        <a href='?act=hapus&id_kereta=".$data['id_kereta']."' onclick='return confirm(\"Yakin ingin hapus?\")'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

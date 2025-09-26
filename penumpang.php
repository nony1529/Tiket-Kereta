<?php
require_once("koneksi.php");

//membuat variabel untuk menampung data
$id_penumpang = "";
$nama = "";
$nik = "";
$no_hp = "";
$email = "";
$alamat = "";
$nameBtn = "input"; 
$valueBtn = "Submit";

//function untuk menginput data penumpang
function inputData($db) {
    mysqli_query($db, "INSERT INTO penumpang (nama, nik, no_hp, email, alamat)
        VALUES(
            '" . $_POST['nama'] . "',
            '" . $_POST['nik'] . "',
            '" . $_POST['no_hp'] . "',
            '" . $_POST['email'] . "',
            '" . $_POST['alamat'] . "'
        )") or die("Gagal Input");
}

//function untuk mengupdate data penumpang
function updateData($db) {
    mysqli_query($db, "UPDATE penumpang SET
        nama = '" . $_POST['nama'] . "',
        nik = '" . $_POST['nik'] . "',
        no_hp = '" . $_POST['no_hp'] . "',
        email = '" . $_POST['email'] . "',
        alamat = '" . $_POST['alamat'] . "'
        WHERE id_penumpang = '" . $_POST['id_penumpang'] . "'
    ") or die("Gagal Update");

    header('location:penumpang.php');
}

//function untuk menghapus data penumpang
function deleteData($db, $id_penumpang) {
    mysqli_query($db, "DELETE FROM penumpang WHERE id_penumpang='$id_penumpang'") or die("Gagal Hapus");
    header('location:penumpang.php');
}

//function untuk mengambil data dan mengedit data penumpang
function getEditData($db, $id_penumpang) {
    $result = mysqli_query($db, "SELECT * FROM penumpang WHERE id_penumpang='$id_penumpang'") or die("Gagal Mengambil Data");
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
        deleteData($db, $_GET['id_penumpang']);
    } elseif ($_GET['act'] === 'edit') {
        $data = getEditData($db, $_GET['id_penumpang']);
        $id_penumpang = $data['id_penumpang'];
        $nama = $data['nama'];
        $nik = $data['nik'];
        $no_hp = $data['no_hp'];
        $email = $data['email'];
        $alamat = $data['alamat'];
        $nameBtn = "update";
        $valueBtn = "Update";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penumpang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Penumpang</h2>
        <form method="post">
            <input type="hidden" name="id_penumpang" value="<?php echo $id_penumpang ?>">

            <label>Nama</label>
            <input type="text" name="nama" value="<?php echo $nama ?>" >

            <label>NIK</label>
            <input type="text" name="nik" value="<?php echo $nik ?>" >

            <label>No. HP</label>
            <input type="text" name="no_hp" value="<?php echo $no_hp ?>" >

            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email ?>" >

            <label>Alamat</label>
            <textarea name="alamat" rows="3" ><?php echo $alamat ?></textarea>

            <button type="submit" name="submit" value="<?php echo $nameBtn ?>"><?php echo $valueBtn ?></button>
        </form>

        <h2>Data Penumpang</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>No. HP</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php
            $query = mysqli_query($db, "SELECT * FROM penumpang ORDER BY id_penumpang DESC");
            $no = 1;
            while ($data = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($data['nama'])."</td>";
                echo "<td>".htmlspecialchars($data['nik'])."</td>";
                echo "<td>".htmlspecialchars($data['no_hp'])."</td>";
                echo "<td>".htmlspecialchars($data['email'])."</td>";
                echo "<td>".nl2br(htmlspecialchars($data['alamat']))."</td>";
                echo "<td class='aksi'>
                        <a href='?act=edit&id_penumpang=".$data['id_penumpang']."'>Edit</a>
                        <a href='?act=hapus&id_penumpang=".$data['id_penumpang']."' onclick='return confirm(\"Yakin ingin hapus?\")'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

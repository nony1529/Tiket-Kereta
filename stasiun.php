<?php
require_once("koneksi.php");

//variabel untuk menampung data
$id_stasiun = "";
$nama_stasiun = "";
$kota = "";
$nameBtn = "input"; 
$valueBtn = "Submit";

//function untuk menginput data stasiun
function inputData($db) {
    mysqli_query($db, "INSERT INTO stasiun (nama_stasiun, kota)
        VALUES(
            '" . $_POST['nama_stasiun'] . "',
            '" . $_POST['kota'] . "'
        )") or die("Gagal Input");
}

//function untuk mengupdate data stasiun
function updateData($db) {
    mysqli_query($db, "UPDATE stasiun SET
        nama_stasiun = '" . $_POST['nama_stasiun'] . "',
        kota = '" . $_POST['kota'] . "'
        WHERE id_stasiun = '" . $_POST['id_stasiun'] . "'
    ") or die("Gagal Update");

    header('location:stasiun.php');
}

//function untuk menghapus data stasiun
function deleteData($db, $id_stasiun) {
    mysqli_query($db, "DELETE FROM stasiun WHERE id_stasiun='$id_stasiun'") or die("Gagal Hapus");
    header('location:stasiun.php');
}

//function untuk mengambil dan mengedit data stasiun
function getEditData($db, $id_stasiun) {
    $result = mysqli_query($db, "SELECT * FROM stasiun WHERE id_stasiun='$id_stasiun'") or die("Gagal Mengambil Data");
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
        deleteData($db, $_GET['id_stasiun']);
    } elseif ($_GET['act'] === 'edit') {
        $data = getEditData($db, $_GET['id_stasiun']);
        $id_stasiun = $data['id_stasiun'];
        $nama_stasiun = $data['nama_stasiun'];
        $kota = $data['kota'];
        $nameBtn = "update";
        $valueBtn = "Update";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Stasiun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Stasiun</h2>
        <form method="post">
            <input type="hidden" name="id_stasiun" value="<?php echo $id_stasiun ?>">

            <label>Nama Stasiun</label>
            <input type="text" name="nama_stasiun" value="<?php echo $nama_stasiun ?>" >

            <label>kota</label>
            <input type="text" name="kota" value="<?php echo $kota ?>" >

            <button type="submit" name="submit" value="<?php echo $nameBtn ?>"><?php echo $valueBtn ?></button>
        </form>

        <h2>Data Stasiun</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Nama Stasiun</th>
                <th>Kota</th>
                <th>Aksi</th>
            </tr>
            <?php
            $query = mysqli_query($db, "SELECT * FROM stasiun ORDER BY id_stasiun DESC");
            $no = 1;
            while ($data = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($data['nama_stasiun'])."</td>";
                echo "<td>".htmlspecialchars($data['kota'])."</td>";
                echo "<td class='aksi'>
                        <a href='?act=edit&id_stasiun=".$data['id_stasiun']."'>Edit</a>
                        <a href='?act=hapus&id_stasiun=".$data['id_stasiun']."' onclick='return confirm(\"Yakin ingin hapus?\")'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

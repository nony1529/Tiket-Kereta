<?php

$server = "localhost";
$user = "root";
$password = "";
$nama_database = "tiket_kereta";

$db = mysqli_connect(hostname: $server, username: $user, password: $password, database: $nama_database);
if (!$db) {
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}
?>
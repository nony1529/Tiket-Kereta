<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Tiket Kereta</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background: #eef2f7;
        }

        .navbar {
            background: #222;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 40px;
        }
        .navbar .logo {
            font-size: 22px;
            font-weight: bold;
            color: #00d4ff;
            letter-spacing: 1px;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        .navbar ul li {
            margin-left: 25px;
        }
        .navbar ul li a {
            color: #f5f5f5;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .navbar ul li a:hover {
            background: #00d4ff;
            color: #222;
        }

        .hero {
            text-align: center;
            padding: 60px 20px;
        }
        .hero h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }
        .hero p {
            font-size: 18px;
            color: #555;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 40px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin: 0;
            color: #0077b6;
        }
        .card p {
            color: #666;
            font-size: 14px;
        }
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 16px;
            background: #0077b6;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .card a:hover {
            background: #0096c7;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">🚄 Tiket Kereta</div>
        <ul>
            <li><a href="penumpang.php">Penumpang</a></li>
            <li><a href="kereta.php">Kereta</a></li>
            <li><a href="stasiun.php">Stasiun</a></li>
            <li><a href="jadwal.php">Jadwal</a></li>
            <li><a href="pemesanan.php">Pemesanan</a></li>
        </ul>
    </div>

    <div class="hero">
        <h1>Selamat Datang di Aplikasi Tiket Kereta 🚆</h1>
        <p>Kelola data penumpang, kereta, stasiun, jadwal, dan pemesanan dengan mudah.</p>
    </div>

    <div class="cards"> 
        <div class="card">
            <h3>Penumpang</h3>
            <p>Kelola data penumpang yang melakukan perjalanan.</p>
            <a href="penumpang.php">Lihat Data</a>
        </div>
        <div class="card">
            <h3>Kereta</h3>
            <p>Data kereta yang tersedia untuk pemesanan tiket.</p>
            <a href="kereta.php">Lihat Data</a>
        </div>
        <div class="card">
            <h3>Stasiun</h3>
            <p>Daftar stasiun keberangkatan dan tujuan.</p>
            <a href="stasiun.php">Lihat Data</a>
        </div>
        <div class="card">
            <h3>Jadwal</h3>
            <p>Jadwal keberangkatan kereta sesuai rute.</p>
            <a href="jadwal.php">Lihat Data</a>
        </div>
        <div class="card">
            <h3>Pemesanan</h3>
            <p>Kelola data pemesanan tiket kereta.</p>
            <a href="pemesanan.php">Lihat Data</a>
        </div>
    </div>

</body>
</html>

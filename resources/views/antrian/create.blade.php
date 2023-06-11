<!-- resources/views/pesanan/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pesanan</title>
</head>
<body>
    <h1>Tambah Pesanan</h1>

    <form action="/pesanan" method="POST">
        @csrf
        <a href="/pesanan">Lihat Daftar Pesanan</a>
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>

        <label for="layanan">Layanan:</label>
        <input type="text" id="layanan" name="layanan" required>

        <button type="submit">Tambah Pesanan</button>
    </form>
</body>
</html>

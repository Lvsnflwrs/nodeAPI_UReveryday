<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <p>Selamat Datang, Admin</p>
        <div class="d-flex justify-content-between align-items-center mb-4">
            
            <h1>Admin Panel</h1>
        
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
        <table class="table table-bordered align-middle text-center">
            <thead class="table table-dark">
                <tr>
                    <th>Foto Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga Produk</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                @isset($products)
                @forelse($products as $produk)
                    <tr>
                        <td>
                            <img src="{{ asset($produk['img_path']) }}" alt="Gambar Produk" style="width: 200px; height: 200px">
                        </td>
                        <td>{{ $produk['nama_produk'] }}</td>
                        <td>{{ $produk['harga_produk'] }}</td>
                        <td>{{ $produk['kategori'] }}</td>
                        <td class="text-start" width="20px">{{ $produk['deskripsi'] }}</td>
                        <td>{{ $produk['status'] }}</td>
                        <td>
                        <form action="{{ route('produk.status.update') }}" method="POST" class="d-inline me-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $produk['id'] }}">
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>

                        <form action="{{ route('produk.status.reject') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $produk['id'] }}">
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada produk dengan status pending.</td>
                        </tr>
                    @endforelse
                    @else
                    <tr>
                        <td colspan="5" class="text-center text-danger">Produk belum dimuat.</td>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

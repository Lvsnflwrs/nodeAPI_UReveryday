<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Produk</title>
    <link rel="stylesheet" href="{{ asset('css/HalamanProduk.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="header">
        <div>
            <a href="/dashboard">
                <img alt="Logo" height="40" src="{{ asset('images/auth/Group 39.png') }}" width="auto" />
            </a>
        </div>
        <div class="nav">
            <a href="{{ route('ShowWishlistPage') }}"><i class="fas fa-heart"></i></a>
            <a href="/profilePage" id="username"><i class="fas fa-user"></i> </a>
            <a class="sell" href="{{ route('ShowAddProduk') }}">Sell</a>
        </div>
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary back-button">Back</a>
    <div class="container my-5">
        <div class="row" style="height: 500px;">
            <div class="col-md-6">
                <div class="image-container">
                    <img 
                        alt="Product Image" src="{{ $product['img_path'] ? asset('images/product/' . $product['img_path']) : 'https://via.placeholder.com/150' }}" height="200" width="auto" 
                    />
                </div>
            </div>
            <div class="col-md-6">
                <div class="details-section">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $product['penjual_profilePic'] }}" alt="User profile picture" class="rounded-circle me-3 border" width="40" height="40">
                            <p class="mb-0 fw-bold text-secondary">{{ $product['penjual_username'] }}</p>
                        </div>
                        <h1>{{ $product['nama_produk'] }}</h1>
                        <p>{{ $product['kategori']}}</p>
                        <p class="price">Rp {{ number_format($product['harga_produk'], 0, ',', '.') }}</p>
                        <p><strong>Details</strong></p>
                        <p>{{ $product['deskripsi'] }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="https://wa.me/{{ $product['penjual_nomorWA'] }}" class="btn btn-dark me-3">Nomor Penjual</a>
                        <form method="POST" action="{{ route('addWishlist') }}">
                            @csrf 
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <button type="submit" class="wishlist-button">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                    <div class="d-flex align-items-center text-muted">
                        <i class="fas fa-truck me-2"></i>
                        <p class="mb-0">Free Delivery around Telkom University</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        const wishlistButton = document.querySelector('.wishlist-button');
        wishlistButton.addEventListener('click', function() {
            wishlistButton.classList.toggle('active');
        });

        $(document).ready(function() {
            // Fetch data user
            // Fetch data user
            const meAPI = '/getUserLogin';
            $.getJSON(meAPI)
                .done(function(response) {
                    const user = response.data || [];
                    console.log(user);
                    if (user.length === 0) {
                        $('#username').append('username');
                    } else {
                        const username = response.data[0].username;
                        $('#username').append(
                            `${username}`); // Perbaikan di sini: gunakan template literal `${username}`
                    }
                });
        });
    </script>
</body>
</html>

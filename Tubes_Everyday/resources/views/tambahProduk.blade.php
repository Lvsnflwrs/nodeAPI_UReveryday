<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UREveryday</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 50px;
            margin-right: 10px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        input[type="file"] {
            border: none;
        }

        .file-upload {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .file-upload input {
            display: none;
        }

        .file-label {
            display: block;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-save {
            display: block;
            margin: 20px auto;
            background-color: #4A63E7;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-cancel {
            display: block;
            margin: 20px auto;
            background-color:darkgrey;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>

<!-- 'img_path', 'nama_produk', 'harga_produk', 'stok', 'kategori', 'sub_kategori', 'deskripsi' -->

<body>
    <div class="container">
        <div class="header">
            <img  src="{{ asset('images/auth/Group 39.png') }}" alt="logo">
            <h1>Upload Produk</h1>
        </div>
        <form method="POST" action="/addProduk" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" placeholder="Nama Produk" required>
            </div>

            <div class="form-group">
                <label for="harga_produk">Harga</label>
                <input type="number" id="harga_produk" name="harga_produk" placeholder="Harga Produk" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="text" id="stok" name="stok" placeholder="Stok Produk" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" id="kategori" name="kategori" required>
            </div>

            <div class="form-group">
                <label for="sub_kategori">Sub Kategori</label>
                <input type="text" id="sub_kategori" name="sub_kategori" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="img_path">Upload Images</label>
                <input type="file" id="img_path" name="img_path" required>
                <small>Maximum 1 images.</small>
            </div>

            <div class="form-group buttons">
                <div class="form-group buttons">
                    <a href="{{ route('dashboard') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">Save</button>                    
                </div>
            </div>
        </form>
    </div>
</body>

</html>
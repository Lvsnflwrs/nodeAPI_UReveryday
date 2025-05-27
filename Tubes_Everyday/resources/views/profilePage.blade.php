<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="{{ asset('css/profilePage.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="sweetalert2.min.css">
</head>

<body>
    <div class="container header">
        <div>
            <a href="/dashboard">
                <img alt="Logo" height="40" src="{{ asset('images/auth/Group 39.png') }}" width="auto" />
            </a>
            <div class="dropdown">
                <a>Kategori <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-content" id="kategori-list">
                    <!-- Data Kategori akan dimuat di sini -->
                </div>
            </div>
        </div>
        <div class="nav">
            <a href="{{ route('ShowWishlistPage') }}"><i class="fas fa-heart"></i></a>
            <a href="/profilePage" id="username"><i class="fas fa-user"></i> </a>
            <a class="sell" href="{{ route('ShowAddProduk') }}">Sell</a>
        </div>
    </div>
    <main>
        {{-- <div class="profile">
            <h1>profile</h1>
            <div class="imageuser">
                <img src="{{ asset('images/default-img.png') }}" id="imgUser" class="fotouser" alt="img user">
                <input type="file" id="uploadPhoto" accept="image/*" style="display: none;">
                <button id="btnUploadPhoto">Upload Foto</button>
            </div>
        </div> --}}

        <div class="input">
            <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data"
                id="updateProfileForm">
                @csrf
                <div class="imageuser">
                    <img src="{{ asset('images/default-img.png') }}" id="imgUser" class="fotouser" alt="img user">
                    <input type="file" id="uploadPhoto" name="foto" accept="image/*" style="display: none;">
                    <button type="button" id="btnUploadPhoto">Upload Foto</button>
                </div>

                <label for="namaDepan">Nama Depan</label>
                <input type="text" id="namaDepan" name="nama_depan">

                <label for="namaBelakang">Nama Belakang</label>
                <input type="text" id="namaBelakang" name="nama_belakang">

                <label for="email">Email</label>
                <input type="email" id="email" name="email">

                <label for="notelp">No Telepon <span>(awal angka +62)</span></label>
                <input type="tel" id="notelp" name="no_telpon">

                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat"></textarea>

                <div class="btn">
                    <button type="submit" class="save">save</button>
                </div>
            </form>
        </div>
    </main>
    <div class="mb"></div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Fetch user login
            const meAPI = '/getUserLogin'
            $.getJSON(meAPI)
                .done(function(response) {
                    const user = response.data || [];
                    console.log(user)
                    if (user.length === 0) {
                        $('#username').append('username');
                    } else {
                        const user = response.data[0];
                        $('#username').append(user.username);
                        $('#namaDepan').val(`${user.nama_depan}`);
                        $('#namaBelakang').val(`${user.nama_belakang}`);
                        $('#email').val(`${user.email}`);
                        $('#notelp').val(`${user.no_telpon}`);
                        $('#alamat').val(`${user.alamat}`);
                        const imgSrc = user.img_path ? user.img_path : '{{ asset('images/default-img.png') }}';
                        $('#imgUser').attr('src', imgSrc);
                    }
                })
                .fail(function() {
                    alert('Failed to load user profile. Please try again later.');
                });
        })

        $(document).ready(function() {
            $('#btnUploadPhoto').click(function(e) {
                e.preventDefault();
                $('#uploadPhoto').click();
            });

            $('#uploadPhoto').change(function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imgUser').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
        $('#updateProfileForm').submit(function(event) {
            // Mencegah form untuk langsung disubmit
            event.preventDefault();

            const namaDepan = $('#namaDepan').val().trim();
            const namaBelakang = $('#namaBelakang').val().trim();
            const email = $('#email').val().trim();
            const notelp = $('#notelp').val().trim();
            const alamat = $('#alamat').val().trim();

            const fields = [namaDepan, namaBelakang, email, notelp, alamat];
            const fieldNames = ['Nama Depan', 'Nama Belakang', 'Email', 'No Telepon', 'Alamat'];

            // Periksa setiap field, jika ada yang kosong, tampilkan SweetAlert dan hentikan proses submit
            for (let i = 0; i < fields.length; i++) {
                if (fields[i] === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `${fieldNames[i]} harus diisi!`,
                    });
                    return; // Berhenti eksekusi dan tidak submit form
                }
            }

            // Jika semua field terisi, form akan disubmit
            this.submit();
        });



        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            });
        @endif
    </script>
</body>

</html>

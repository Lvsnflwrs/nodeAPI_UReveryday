$(document).ready(function() {
    // Fetch categories
    const categoryApiUrl = '/getCategory';
    $.getJSON(categoryApiUrl)
        .done(function(response) {
            const categories = response.data || [];
            if (categories.length === 0) {
                $('#kategori-list').append('<a href="#">No category available</a>');
            } else {
                categories.forEach(function(item) {
                    const category = item.kategori || "Unknown Category";
                    $('#kategori-list').append(`<a href="#">${category}</a>`);
                });
            }
        })
        .fail(function() {
            $('#kategori-list').append('<a href="#">Failed to load categories</a>');
        });

    // Fetch products
    const productApiUrl = '/getProdukExDesc';
    $.getJSON(productApiUrl)
        .done(function(response) {
            const products = response.data || [];
            if (products.length === 0) {
                $('#data-table').append('<tr><td colspan="4">No products available.</td></tr>');
            } else {
                let rows = '';
                let rowCount = 0;
                products.forEach(function(item) {
                    const productId = item.id;
                    const productName = item.nama_produk || "Unknown Product";
                    const productImage = `/images/product/${item.img_path}`;
                    const productPrice = item.harga_produk ? `Rp ${parseInt(item.harga_produk).toLocaleString()}` : "Price not available";
                    const productCategory = item.kategori || "Unknown Category";

                    if (rowCount === 0) {
                        rows += '<tr>';
                    }

                    rows += `
                        <td>
                            <div class="product-item">
                                <div class="product-image">
                                    <img alt="Product Image" height="200" src="${productImage}" width="auto" />
                                </div>
                                <div class="info">
                                    <div class="name">${productName}</div>
                                    <div class="price">${productPrice}</div>
                                    <div class="description">${productCategory}</div>
                                </div>
                                <div class="detail-button">
                                    <a href="{{ route('halamanProduk') }}?id=${productId}">Lihat Detail</a>
                                </div>
                            </div>
                        </td>
                    `;

                    rowCount++;
                    if (rowCount === 4) {
                        rows += '</tr>';
                        rowCount = 0;
                    }
                });

                if (rowCount > 0) {
                    rows += '</tr>';
                }

                $('#data-table').append(rows);
            }
        })
        .fail(function() {
            $('#data-table').append('<tr><td colspan="4">Failed to load data.</td></tr>');
        });

    // Event click pada kategori untuk mengosongkan tabel dan memuat ulang data produk
    $(document).on('click', '#kategori-list a', function(event) {
        event.preventDefault();

        const selectedCategory = $(this).data('category');
        const apiUrlProduk = `/getProduk/${selectedCategory}`;

        // Kosongkan tabel
        $('#data-table').empty();

        // Muat data produk berdasarkan kategori
        $.getJSON(apiUrlProduk)
            .done(function(response) {
                const products = response.data || [];
                if (products.length === 0) {
                    $('#data-table').append('<tr><td colspan="4">No products available in this category.</td></tr>');
                } else {
                    let rows = '';
                    let rowCount = 0;
                    products.forEach(function(item) {
                        const productName = item.nama_produk || "Unknown Product";
                        const productImage = `/images/product/${item.img_path}`;
                        const productPrice = item.harga_produk ? `Rp ${parseInt(item.harga_produk).toLocaleString()}` : "Price not available";
                        const productCategory = item.kategori || "Unknown Category";

                        if (rowCount === 0) {
                            rows += '<tr>';
                        }

                        rows += `
                            <td>
                                <div class="product-item">
                                    <div class="product-image">
                                        <img alt="Product Image" height="200" src="${productImage}" width="auto" />
                                    </div>
                                    <div class="info">
                                        <div class="name">${productName}</div>
                                        <div class="price">${productPrice}</div>
                                        <div class="description">${productCategory}</div>
                                    </div>
                                    <div class="detail-button">
                                        <a href="{{ route('halamanProduk') }}?id=${productId}">Lihat Detail</a>
                                    </div>
                                </div>
                            </td>
                        `;

                        rowCount++;
                        if (rowCount === 4) {
                            rows += '</tr>';
                            rowCount = 0;
                        }
                    });

                    if (rowCount > 0) {
                        rows += '</tr>';
                    }

                    $('#data-table').append(rows);
                }
            })
            .fail(function() {
                $('#data-table').append('<tr><td colspan="4">Failed to load products for this category.</td></tr>');
            });
    });
});
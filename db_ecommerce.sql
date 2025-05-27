CREATE TABLE `users`(
    `id` BIGINT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nama_depan` VARCHAR(255) NULL,
    `nama_belakang` VARCHAR(255) NULL,
    `alamat` TEXT NULL,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` TEXT NOT NULL,
    `img_path` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
CREATE TABLE `produk`(
    `id` BIGINT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `idPenjual` BIGINT NULL,
    `img_path` TEXT NULL,
    `nama_produk` VARCHAR(255) NULL,
    `harga_produk` INT NOT NULL,
    `stok` INT NOT NULL,
    `kategori` VARCHAR(255) NOT NULL,
    `sub_kategori` VARCHAR(255) NULL,
    `deskripsi` TEXT NULL,
    `status` ENUM('accepted','pending','rejected') DEFAULT 'pending',
    `created_at` TIMESTAMP NOT NULL,
    `updated_at` TIMESTAMP NULL
);
CREATE TABLE `wishlist`(
    `id` BIGINT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT NOT NULL,
    `product_id` BIGINT NOT NULL,
    `created_at` BIGINT NULL,
    `updated_at` TIMESTAMP NULL
);
CREATE TABLE `admin`(
    `id` BIGINT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `password` TEXT NOT NULL,
    `created_at` BIGINT NULL,
    `updated_at` TIMESTAMP NULL
);
ALTER TABLE
    `wishlist` ADD CONSTRAINT `wishlist_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);
ALTER TABLE
    `produk` ADD CONSTRAINT `produk_idpenjual_foreign` FOREIGN KEY(`idPenjual`) REFERENCES `users`(`id`);
ALTER TABLE
    `wishlist` ADD CONSTRAINT `wishlist_product_id_foreign` FOREIGN KEY(`product_id`) REFERENCES `produk`(`id`);
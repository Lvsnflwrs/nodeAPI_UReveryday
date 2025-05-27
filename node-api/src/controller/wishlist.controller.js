require("dotenv").config();
const modelWishlist = require("../models/wishlist");
const JWT_SECRET = process.env.JWT_SECRET || "your_jwt_secret_key"; // Menggunakan JWT_SECRET dari environment variables
const jwt = require("jsonwebtoken");

const getWishlistHandler = async (req, res) => {
  const token = req.headers["authorization"]?.split(" ")[1];
  if (!token) {
    return res.status(403).json({ message: "Token tidak ditemukan" });
  }

  try {
    const decoded = jwt.verify(token, JWT_SECRET);
    const user_id = decoded.id; 

    const [found] = await modelWishlist.getWishlist(user_id);
    if (found.length > 0) {
      return res.status(200).json({ message: "Menampilkan wishlist", data: found });
    }
    return res.status(400).json({ message: "Tidak ada item dalam wishlist" });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error", error: error.message });
  }
};

// Menambahkan item ke wishlist
const addWishlistHandler = async (req, res) => {
  const {  product_id } = req.params;
  const user_id = req.id;

  try {
    const [existing] = await modelWishlist.searchWishlist(user_id, product_id);
    if (existing.length > 0) {
      return res.status(409).json({ message: "Produk sudah ada di wishlist" });
    }

    const [result] = await modelWishlist.addWishlist(user_id, product_id);
    if (result.affectedRows > 0) {
      return res.status(200).json({ message: "Wishlist berhasil ditambahkan" });
    }

    return res.status(400).json({ message: "Gagal menambahkan Wishlist" });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error", error: error.message });
  }
};

// Menghapus item dari wishlist
const removeWishlistHandler = async (req, res) => {
  const { id } = req.params; // Mengganti wishlist_id dengan id
  // Memeriksa apakah id valid
  if (!id) {
    return res.status(400).json({ message: "ID tidak valid" });
  }

  try {
    const result = await modelWishlist.removeWishlist(id); // Menggunakan id
 
    if (result.affectedRows > 0) {
      return res.status(200).json({
        message: `Produk dengan ID ${id} telah dihapus.`,
      });
    }

    return res.status(404).json({
      message: `Produk dengan ID ${id} tidak ditemukan.`,
    });
  } catch (error) {
    console.error("Error saat menghapus wishlist:", error);
    return res.status(500).json({ message: "Server error", error: error.message });
  }
};

module.exports = {
  getWishlistHandler,
  addWishlistHandler,
  removeWishlistHandler,
};
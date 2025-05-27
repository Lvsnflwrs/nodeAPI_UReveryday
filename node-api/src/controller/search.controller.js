require("dotenv").config();
const modelProduk = require("../models/produk");

const searchProdukHandler = async (req, res) => {
    const { searchTerm } = req.query;

    if (!searchTerm || searchTerm.trim() === "") {
    return res.status(400).json({ message: "Kata kunci pencarian tidak boleh kosong" });
    }

    try {
        const found = await modelProduk.searchProduk(searchTerm);

        if (found && found.length > 0) {
        return res.status(200).json({
            message: `Hasil pencarian untuk ${searchTerm}`,
            data: found,
        });
        }
        
        // Produk tidak ditemukan
        return res.status(404).json({ message: "Produk tidak ada di database" });
    } catch (error) {
        console.error("Controller error:", error);
        res.status(500).json({
        message: "Server error",
        error: error.message || "Unknown error occurred",
        });
    }
    };

module.exports = {
    searchProdukHandler,
};
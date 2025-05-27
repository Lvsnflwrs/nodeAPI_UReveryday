const conn = require("../config/db_connection");

const getAllProduk = () => {
  const QUERY = "SELECT * FROM produk";
  try {
    return conn.execute(QUERY);
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
};

const getProdukPending = async () => {
  const QUERY = "SELECT * FROM produk WHERE status = ?";
  try {
    const [rows] = await conn.execute(QUERY, ['pending']);
    return rows;
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
}

const getProdukAcc = async () => {
  const QUERY = "SELECT * FROM produk WHERE status = ?";
  try {
    const [rows] = await conn.execute(QUERY, ['accepted']);
    return rows;
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
}

const getAllProdukExDesc = () => {
  const QUERY = "SELECT id, img_path, nama_produk, harga_produk, stok, kategori, sub_kategori FROM produk";
  try {
    return conn.execute(QUERY);
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
};

const getProdukByID = (id) => {
  const QUERY = `
  SELECT produk.id, produk.img_path, produk.nama_produk, produk.harga_produk, produk.stok, produk.kategori, produk.sub_kategori, produk.deskripsi,
  users.username AS penjual_username,
  users.img_path AS penjual_profilePic,
  users.no_telpon AS penjual_nomorWA
  FROM produk
  LEFT JOIN users ON produk.idPenjual = users.id WHERE produk.id = ?`;

  try {
    return conn.execute(QUERY, [id]);
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
};

const getProdukByCategory = async (kategori) => {
  const QUERY = "SELECT * FROM produk WHERE kategori = ?";
  try {
    return await conn.execute(QUERY, [kategori]);
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
};

const getCategory = () => {
  const QUERY = "SELECT kategori FROM produk GROUP BY kategori";
  try {
    return conn.execute(QUERY);
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
}

const addProduk = (idPenjual, img_path, nama_produk, harga_produk, stok, kategori, sub_kategori, deskripsi) => {
  const QUERY = "INSERT INTO produk (idPenjual, img_path, nama_produk, harga_produk, stok, kategori, sub_kategori, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  return conn.execute(QUERY, [idPenjual, img_path, nama_produk, harga_produk, stok, kategori, sub_kategori, deskripsi])
    .then(([result]) => {
      console.log("Insert Result:", result);
      return [result];
    })
    .catch(error => {
      console.error("Database error:", error);
      throw new Error("Failed to insert data into the database");
    });
};

const updateProduk = async (
  id,
  status
) => {
  const QUERY =
    "UPDATE produk SET status = ?, updated_at = NOW() WHERE id = ?";
  return conn.execute(QUERY, [
    status,
    id
  ]);
};

const deleteProduk = async (id) => {
  const QUERY = "DELETE FROM produk WHERE id = ?";
  return conn.execute(QUERY, [id]);
};


const searchProduk = async (searchTerm) => {
  const QUERY = "SELECT * FROM produk WHERE nama_produk LIKE ? OR kategori LIKE ?";
  try {
    const [rows] = await conn.execute(QUERY, [`%${searchTerm}%`, `%${searchTerm}%`]);
    return rows;
  } catch (error) {
    console.error("Database error:", error);
    throw new Error("Failed to fetch data from the database");
  }
};

module.exports = {
  deleteProduk,
  updateProduk,
  getAllProduk,
  getProdukByID,
  getProdukPending,
  getProdukAcc,
  getProdukByCategory,
  getCategory,
  addProduk,
  getAllProdukExDesc,
  searchProduk
};

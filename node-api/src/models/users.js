const conn = require("../config/db_connection");
const bcrypt = require("bcrypt");

const getAllUser = () => {
  const QUERY = "SELECT * FROM users";
  return conn.execute(QUERY);
};

const getUserByEmail = (email) => {
  const QUERY = "SELECT * FROM users WHERE email = ?";
  return conn.execute(QUERY, [email]);
};

const getUserByID = (id) => {
  const QUERY = "SELECT * FROM users WHERE id = ?";
  return conn.execute(QUERY, [id]);
};

const addUser = async (nama_depan, nama_belakang, username, email, plainPassword) => {
  const QUERY =
    "INSERT INTO users (nama_depan, nama_belakang, username, email, password, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
  const salt = 10;
  const hashed = await bcrypt.hash(plainPassword, salt);
  return conn.execute(QUERY, [
    nama_depan,
    nama_belakang,
    username,
    email,
    hashed,
  ]);
};

const getAdmin = () => {
  const QUERY = "SELECT * FROM admin";
  return conn.execute(QUERY);
};

const getAdminByUname = (username) => {
  const QUERY = "SELECT * FROM admin WHERE username = ?";
  return conn.execute(QUERY, [username]);
};

const addAdmin = async (username, password) => {
  const QUERY =
    "INSERT INTO admin (username, password, created_at) VALUES (?, ?, NOW())";
  const salt = 10;
  const hashed = await bcrypt.hash(password, salt);
  return conn.execute(QUERY, [
    username,
    hashed,
  ]);
};

const updateProfile = async (
  id,
  nama_depan,
  nama_belakang,
  no_telpon,
  alamat,
  email,
  img_path
) => {
  const QUERY =
    "UPDATE users SET nama_depan = ?, nama_belakang = ?, no_telpon = ?, alamat = ?, email = ?, img_path = ?, updated_at = NOW() WHERE id = ?";
  return conn.execute(QUERY, [
    nama_depan,
    nama_belakang,
    no_telpon,
    alamat,
    email,
    img_path,
    id,
  ]);
};

module.exports = {
  getAllUser,
  getUserByEmail,
  getUserByID,
  addUser,
  getAdmin,
  getAdminByUname,
  addAdmin,
  updateProfile
};
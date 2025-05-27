require("dotenv").config();
const modelUser = require("../models/users");
const {
  getStorage,
  ref,
  uploadBytes,
  getDownloadURL,
  deleteObject,
} = require("firebase/storage");
const firebaseConfig = require("../config/firebase.config");
const path = require("path");

const getAllUser = async (req, res) => {
  try {
    const [dataUser] = await modelUser.getAllUser();
    if (dataUser.length > 0) {
      res
        .status(200)
        .json({ message: "menampilkan semua data user", data: dataUser });
    } else {
      res.status(200).json({ message: "tidak ada data user" });
    }
  } catch (error) {
    console.log(error);
    res.status(500).json({ message: "Server error", error: error.message });
  }
};

const updateProfile = async (req, res) => {
  const id = req.id;
  const foto = req.file;
  const {
    nama_depan = null,
    nama_belakang = null,
    email = null,
    no_telpon = null,
    alamat = null,
  } = req.body;

  try {
    const [userData] = await modelUser.getUserByID(id);
    const found = userData[0];
    const RS = {
      id,
      nama_depan,
      nama_belakang,
      email ,
      no_telpon,
      alamat ,
    }
    console.log(RS)
    if (!found) {
      return res.status(404).json({ message: "User tidak ditemukan." });
    }

    let profilePictURL = found.img_path

    if (foto) {
      if (found.img_path) {
        const filePath = found.img_path.split("/o/")[1].split("?")[0];
        const decodedPath = decodeURIComponent(filePath);

        const { firebaseStorage } = await firebaseConfig();
        const fileRef = ref(firebaseStorage, decodedPath);

        try {
          await deleteObject(fileRef);
        } catch (err) {
          console.error("Gagal menghapus gambar lama:", err.message);
          return res.status(500).json({
            message: "Gagal menghapus gambar lama.",
            error: err.message,
          });
        }
      }

      profilePictURL = await uploadNewProfilePicture(foto);
    }

    await modelUser.updateProfile(
      id,
      nama_depan,
      nama_belakang,
      no_telpon,
      alamat,
      email,
      profilePictURL
    );

    res.status(200).json({
      message: "Profile berhasil diperbarui.",
    });
  } catch (error) {
    console.error("Error saat memperbarui profil:", error);
    res
      .status(500)
      .json({ message: "Terjadi kesalahan saat memperbarui profil." });
  }
};

const uploadNewProfilePicture = async (profilePictFile) => {
  if (!profilePictFile) {
    throw new Error("File tidak valid");
  }

  const profilePictFileExtension = path.extname(profilePictFile.originalname);
  const profilePictFileOriginalName = path.basename(
    profilePictFile.originalname,
    profilePictFileExtension
  );
  const newProfilePictfileName = `${Date.now()}_${profilePictFileOriginalName}${profilePictFileExtension}`;
  const { firebaseStorage } = await firebaseConfig();
  const storageRef = ref(
    firebaseStorage,
    `amar-project/foto-profile-user/${newProfilePictfileName}`
  );

  const profilePictBuffer = profilePictFile.buffer;

  const resultProfilePict = await uploadBytes(storageRef, profilePictBuffer, {
    contentType: profilePictFile.mimetype,
  });

  return await getDownloadURL(resultProfilePict.ref);
};

module.exports = {
  getAllUser,
  updateProfile,
};
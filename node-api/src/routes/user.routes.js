const express = require("express")
const router = express.Router()
const usersController = require("../controller/users.controller")
const multer = require('../middleware/multer')
const verifyJWT = require('../middleware/verifyJWT')

router.get("/getAllUser", usersController.getAllUser)
router.put('/updateProfile', verifyJWT, multer.single('foto'), usersController.updateProfile);

module.exports = router;
const express = require("express");
const router = express.Router();
const authModel = require("../controller/auth.controller");
const verifyJWT = require("../middleware/verifyJWT");

router.post("/login", authModel.login);
router.get("/me", verifyJWT, authModel.me);
router.post("/signup", authModel.signup);
router.post("/signUpAdmin", authModel.signUpAdmin);
router.post("/loginAdmin", authModel.loginAdmin);


module.exports = router;

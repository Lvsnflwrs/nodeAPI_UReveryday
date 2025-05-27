const express = require("express");
const router = express.Router();
const { searchProdukHandler } = require("../controller/search.controller.js");

router.get("/searchProduk", searchProdukHandler);

module.exports = router;
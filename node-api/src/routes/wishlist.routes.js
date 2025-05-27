const express = require("express");
const router = express.Router();
const wishlistModel = require("../controller/wishlist.controller");
const verifyJWT = require('../middleware/verifyJWT')

router.get("/getWishlist", wishlistModel.getWishlistHandler);
router.post("/addWishlist/:product_id", verifyJWT, wishlistModel.addWishlistHandler);
router.delete("/removeWishlist/:id", wishlistModel.removeWishlistHandler);

module.exports = router;


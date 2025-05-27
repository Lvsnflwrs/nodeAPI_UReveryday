require("dotenv").config();
const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");

const app = express();
const port = process.env.PORT || 3000;
const userRoutes = require("./routes/user.routes");
const authRoutes = require("./routes/auth.routes");
const produkRoutes = require("./routes/produk.routes");
const wishlistRoutes = require("./routes/wishlist.routes");
const searchRoutes = require("./routes/search.routes");

app.use(cors());
app.use(express.json());
app.use("/api/users", userRoutes);
app.use("/api/auth", authRoutes);
app.use("/api/produk", produkRoutes);
app.use("/api/wishlist", wishlistRoutes);
app.use("/api/search", searchRoutes);

app.listen(port, () => {
  console.log(`Node.js API listening at http://localhost:${port}`);
});

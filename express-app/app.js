import express from "express";
import bodyParser from "body-parser";
import mongoose from "mongoose";
import cors from "cors";
import Customer from "./src/models/customer.js";
const app = express();

mongoose.connect("mongodb://localhost:27017/be", {
  useNewUrlParser: true,
  useUnifiedTopology: true,
});

const db = mongoose.connection;

db.on("error", (err) => {
  console.error("Error connecting to MongoDB: " + err.message);
});

db.once("open", () => {
  console.log("Connected to MongoDB");
});

app.use(cors());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app
  .route("/customer")
  .get(async (req, res) => {
    const customers = await Customer.find({});
    if (customers) {
      return res.status(200).json({ data: customers });
    } else {
      return res.status(500).json({ error: "Something went wrong" });
    }
  })
  .post(async (req, res) => {
    const newCustomer = new Customer(req.body);
    const customer = await newCustomer.save();
    if (!customer) {
      return res.status(500).json({ error: err.message });
    } else {
      return res.status(200).json({ data: customer });
    }
  });

app.put("/customer/:customerId", async (req, res) => {
  const customerId = req.params.customerId;

  if (!customerId) {
    return res.status(400).json({ error: "Missing customerId parameter" });
  }

  const customer = await Customer.findByIdAndUpdate(customerId, req.body, {
    new: true,
  });

  if (customer) {
    return res.status(200).json({ data: customer });
  } else {
    return res.status(500).json({ error: "Something went wrong" });
  }
});

app.delete("/customer/:customerId", async (req, res) => {
  const customerId = req.params.customerId;

  if (!customerId) {
    return res
      .status(400)
      .json({ error: "Parameter customerId required", data: null });
  }

  try {
    const customer = await Customer.findByIdAndRemove(customerId);
    if (customer) {
      return res.status(200).json({ data: customer, error: null });
    } else {
      return res.status(404).json({ data: null, error: "Customer not found" });
    }
  } catch (error) {
    return res.status(500).json({ error, data: null });
  }
});

app.listen(3002, () => {
  console.log("App is running on port 3002");
});

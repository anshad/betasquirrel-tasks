import mongoose from "mongoose";

const customerSchema = new mongoose.Schema({
  name: String,
  email: String,
  mobile: String,
});

export default mongoose.model("Customer", customerSchema);

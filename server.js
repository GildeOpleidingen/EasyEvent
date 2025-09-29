const express = require("express");
const multer = require("multer");
const fetch = require("node-fetch");
const cors = require("cors");

const app = express();
app.use(cors());

const upload = multer(); // for parsing multipart/form-data

const RECAPTCHA_SECRET = "6LePJs0rAAAAABAiA324JCCmHmiIS4Tp0nf2Bsho";

app.post("/register", upload.none(), async (req, res) => {
  console.log("--- New form submission ---");
  const token = req.body["g-recaptcha-response"];
  console.log("Received token from client:", token);

  if (!token) return res.status(400).send("No reCAPTCHA token provided.");

  try {
    const verificationUrl = `https://www.google.com/recaptcha/api/siteverify?secret=${RECAPTCHA_SECRET}&response=${token}`;
    const response = await fetch(verificationUrl, { method: "POST" });
    const data = await response.json();

    console.log("Verification response from Google:", data);

    if (data.success && data.score >= 0.5) {
      console.log("Token is valid. Processing form...");
      res.send("Form submitted successfully!");
    } else {
      console.log("Token invalid or suspicious. Rejecting submission.");
      res.status(400).send("reCAPTCHA verification failed.");
    }
  } catch (err) {
    console.error("Error verifying reCAPTCHA:", err);
    res.status(500).send("Error verifying reCAPTCHA.");
  }

  console.log("--- End of submission ---\n");
});

app.listen(3000, () =>
  console.log("Node server running on http://localhost:3000")
);

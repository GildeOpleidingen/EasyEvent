async function captcha(action, button) {
  button.disabled = true; // prevent double clicks

  await grecaptcha.enterprise.ready(async () => {
    const token = await grecaptcha.enterprise.execute(
      "6LeUUswrAAAAAG8pJA-q2dSL77YATUh2GwaOvlQF",
      { action }
    );

    const form = button.form;
    const formData = new FormData(form);
    formData.append("g-recaptcha-response", token);

    try {
      const response = await fetch("http://localhost:3000/register", {
        method: "POST",
        body: formData,
      });

      const text = await response.text();
      console.log("Server response:", text);

      if (response.ok) {
        // Optionally, redirect or show success message
        alert("Form submitted successfully!");
      } else {
        alert("reCAPTCHA verification failed. Please try again.");
      }
    } catch (err) {
      console.error("Error submitting form:", err);
      alert("Error submitting form.");
    } finally {
      button.disabled = false;
    }
  });
}

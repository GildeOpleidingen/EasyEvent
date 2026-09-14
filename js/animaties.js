// Logo
gsap.from(".logo-img", {
  opacity: 0,
  scale: 0.5,
  duration: 1,
  ease: "bounce.out",
});

gsap.from("h1", {
  x: -100,
  opacity: 0,
  duration: 1,
  delay: 0.5,
  ease: "power2.out",
});

gsap.from("p", {
  x: -100,
  opacity: 0,
  duration: 1,
  delay: 0.7,
  ease: "power2.out",
});

gsap.from(".form-floating", {
  y: 50,
  opacity: 0,
  duration: 0.8,
  delay: 1,
  stagger: 0.2,
  ease: "power1.out",
});

gsap.from(".g-recaptcha", {
  scale: 0.8,
  opacity: 0,
  duration: 0.8,
  delay: 2,
  ease: "elastic.out(1, 0.5)",
});

gsap.from(".login-btn", {
  scale: 0.8,
  opacity: 0,
  duration: 0.8,
  delay: 1.6,
  ease: "elastic.out(1, 0.5)",
});

gsap.from(".register-btn", {
  scale: 0.8,
  opacity: 0,
  duration: 0.8,
  delay: 2.5,
  ease: "elastic.out(1, 0.5)",
});

gsap.fromTo(
  ".event-item",
  {
    opacity: 0,
    y: 50,
  },
  {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: "power2.out",
    stagger: 0.2,
  }
);

// Calendar
gsap.from(".calendar-header h3", {
  opacity: 0,
  y: -20,
  duration: 0.8,
  ease: "power2.out",
  delay: 0.2,
});

gsap.fromTo(
  ".calendar-day",
  {
    opacity: 0,
    y: 20,
  },
  {
    opacity: 1,
    y: 0,
    duration: 0.6,
    ease: "bounce.out",
    stagger: {
      grid: [7, 5],
      from: "start",
      amount: 1,
    },
  }
);

document.querySelectorAll(".calendar-header button").forEach((button) => {
  button.addEventListener("click", () => {
    gsap.to(".calendar-day", {
      opacity: 0,
      x: -30,
      duration: 0.4,
      ease: "power2.in",
      onComplete: () => {
        gsap.fromTo(
          ".calendar-day",
          {
            opacity: 0,
            x: 30,
          },
          {
            opacity: 1,
            x: 0,
            duration: 0.6,
            ease: "power2.out",
            stagger: 0.05,
          }
        );
      },
    });
  });
});

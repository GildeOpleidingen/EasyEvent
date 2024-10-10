// Logo
gsap.from(".logo-img", {
    opacity: 0,
    scale: 0.5,
    duration: 1,
    ease: "bounce.out"
});

gsap.from("h1", {
    x: -100,
    opacity: 0,
    duration: 1,
    delay: 0.5,
    ease: "power2.out"
});

gsap.from("p", {
    x: -100,
    opacity: 0,
    duration: 1,
    delay: 0.7,
    ease: "power2.out"
});

gsap.from(".form-floating", {
    y: 50,
    opacity: 0,
    duration: 0.8,
    delay: 1,
    stagger: 0.2,
    ease: "power1.out"
});

gsap.from(".login-btn", {
    scale: 0.8,
    opacity: 0,
    duration: 0.8,
    delay: 1.6,
    ease: "elastic.out(1, 0.5)"
});

gsap.from(".register-btn", {
    scale: 0.8,
    opacity: 0,
    duration: 0.8,
    delay: 2.5,
    ease: "elastic.out(1, 0.5)"
});


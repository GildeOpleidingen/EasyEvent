// Preloader
const loader = document.getElementById("loader");
const content = document.getElementById("content");

content.style.display = "none";

setTimeout(() => {
    loader.style.display = "none";
    content.style.display = "block";

    gsap.from("#content", { opacity: 0, duration: 1.5, ease: "power2.out"});
    gsap.from("nav", { opacity: 0, y: -50, duration: 1, ease: "power2.out", delay: 0.5 });
}, 3000);
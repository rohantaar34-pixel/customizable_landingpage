const menuToggle = document.getElementById("menuToggle");
const mobileMenu = document.getElementById("mobileMenu");
const overlay = document.getElementById("overlay");
const menuIcon = document.getElementById("menuIcon");
const closeIcon = document.getElementById("closeIcon");
const navbar = document.getElementById("navbar");

menuToggle.addEventListener("click", function () {
  const isOpen = !mobileMenu.classList.contains("translate-x-full");

  if (isOpen) {
    // Close menu
    mobileMenu.classList.add("translate-x-full");
    overlay.classList.add("hidden");
    menuIcon.classList.remove("hidden");
    closeIcon.classList.add("hidden");
    document.body.style.overflow = "auto";
    navbar.classList.add("shadow-xl");
  } else {
    // Open menu
    mobileMenu.classList.remove("translate-x-full");
    overlay.classList.remove("hidden");
    menuIcon.classList.add("hidden");
    closeIcon.classList.remove("hidden");
    document.body.style.overflow = "hidden";
    navbar.classList.remove("shadow-xl");
  }
});

// Close menu when clicking overlay
overlay.addEventListener("click", function () {
  mobileMenu.classList.add("translate-x-full");
  overlay.classList.add("hidden");
  menuIcon.classList.remove("hidden");
  closeIcon.classList.add("hidden");
  document.body.style.overflow = "auto";
});

// Close menu when clicking a link
const mobileLinks = mobileMenu.querySelectorAll("a");
mobileLinks.forEach((link) => {
  link.addEventListener("click", function () {
    mobileMenu.classList.add("translate-x-full");
    overlay.classList.add("hidden");
    menuIcon.classList.remove("hidden");
    closeIcon.classList.add("hidden");
    document.body.style.overflow = "auto";
  });
});

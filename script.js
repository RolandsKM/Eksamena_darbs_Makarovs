let index = 0;

function showSlide() {
    const carousel = document.querySelector('.carousel');
    const totalSlides = document.querySelectorAll('.volunteer-type').length;
    
    // Adjust index when it's out of bounds
    if (index < 0) {
        index = totalSlides - 2; // Go to the second-to-last slide
    } else if (index >= totalSlides - 1) {
        index = 0; // Loop back to the first slide
    }

    // Set the transform value to move the carousel
    carousel.style.transform = `translateX(-${index * (50 + 1)}%)`; // (50% width + 1rem margin)
}

function prevSlide() {
    index--;
    showSlide();
}

function nextSlide() {
    index++;
    showSlide();
}

document.addEventListener("DOMContentLoaded", function () {
    const profileBtn = document.querySelector(".profile-btn");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    if (profileBtn) {
        profileBtn.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent click from propagating to document
            dropdownMenu.classList.toggle("show");
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (!profileBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove("show");
        }
    });
});

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

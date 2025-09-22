document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll(".star-rating .star");
    const ratingInput = document.querySelector(".star-rating input[name='rating']");

    if (!stars.length || !ratingInput) return;

    function highlightStars(rating) {
        stars.forEach(star => {
            star.classList.toggle("selected", star.dataset.value <= rating);
        });
    }

    stars.forEach(star => {
        // Hover (iluminar estrellas temporalmente)
        star.addEventListener("mouseover", function () {
            highlightStars(this.dataset.value);
        });

        // Salir del hover (volver al valor actual)
        star.addEventListener("mouseout", function () {
            highlightStars(ratingInput.value);
        });

        // Click (guardar selección)
        star.addEventListener("click", function () {
            ratingInput.value = this.dataset.value;
            highlightStars(this.dataset.value);
        });
    });

    // Inicializar según el valor ya existente (ej: old('rating'))
    if (ratingInput.value > 0) {
        highlightStars(ratingInput.value);
    }
});

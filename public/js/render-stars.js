document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".star-rating").forEach((ratingDiv) => {
        const rating = parseFloat(ratingDiv.dataset.rating) || 0;

        const fullStars = Math.floor(rating);
        const halfStar = rating - fullStars >= 0.5;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

        let starsHtml = "";

        for (let i = 0; i < fullStars; i++) {
            starsHtml += '<i class="bi bi-star-fill text-warning"></i>';
        }

        if (halfStar) {
            starsHtml += '<i class="bi bi-star-half text-warning"></i>';
        }

        for (let i = 0; i < emptyStars; i++) {
            starsHtml += '<i class="bi bi-star text-warning"></i>';
        }

        ratingDiv.innerHTML = starsHtml;
    });
});

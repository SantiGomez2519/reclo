/**
 * Author: Santiago Gómez 
 * 
 * Product Image Preview Functionality
 * Handles image preview when user selects a file
 */
document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("image");

    if (imageInput) {
        imageInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Try to find preview container
                    const container = document.querySelector(
                        ".image-preview-container"
                    );
                    if (container) {
                        container.innerHTML = `
                            <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                            <p class="text-muted mt-2">${file.name}</p>
                        `;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

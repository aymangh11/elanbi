
// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", function () {
    const categoryLinks = document.querySelectorAll(".list-group-item");
    const products = document.querySelectorAll(".products-single");

    // Add click event listeners to each category link
    categoryLinks.forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior
            const selectedCategory = this.getAttribute("data-category");

            // Highlight the active category
            categoryLinks.forEach((link) => link.classList.remove("active"));
            this.classList.add("active");

            // Show or hide products based on the selected category
            products.forEach((product) => {
                const productCategory = product.parentElement.getAttribute("data-category");
                if (selectedCategory === "ALL" || productCategory === selectedCategory) {
                    product.parentElement.style.display = "block"; // Show product
                } else {
                    product.parentElement.style.display = "none"; // Hide product
                }
            });
        });
    });
});


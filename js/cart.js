// Initialize cart from LocalStorage or an empty array
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Function to update the cart badge
function updateCartBadge() {
    const badge = document.querySelector('.attr-nav .badge');
    const totalItems = cart.reduce((acc, item) => acc + item.quantity, 0);
    badge.textContent = totalItems;
}

function showNotification(message) {
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notification-message');
    notificationMessage.textContent = message;
    notification.classList.remove('hidden');
    notification.classList.add('show');

    // Hide the notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        notification.classList.add('hidden');
    }, 3000);
}

// Function to add a product to the cart
function addToCart(product) {
    const existingProduct = cart.find(item => item.id === product.id);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    
    updateCartBadge();
    showNotification("Produit ajouté au panier"); // Update badge after adding
}

// Function to display the cart on the cart page
function displayCart() {
    const cartItemsContainer = document.getElementById("cart-items");
    const grandTotalElement = document.getElementById("grand-total");
    cartItemsContainer.innerHTML = "";
    let grandTotal = 0;

    cart.forEach((product, index) => {
        const productTotal = product.price * product.quantity;
        grandTotal += productTotal;

        cartItemsContainer.innerHTML += `
            <tr>
                <td><img src="${product.image}" class="cart-thumb" alt="${product.name}" style="width: 50px;"></td>
                <td>${product.name}</td>
                <td>$${product.price}</td>
                <td>
                    <input type="number" value="${product.quantity}" min="1" onchange="updateQuantity(${index}, this.value)">
                </td>
                <td>$${productTotal.toFixed(2)}</td>
                <td><button class="btn btn-danger" onclick="removeFromCart(${index})">Supprimer</button></td>
            </tr>
        `;
    });

    grandTotalElement.textContent = `$${grandTotal.toFixed(2)}`;
    updateCartBadge(); // Update badge when displaying cart
}

// Function to update product quantity
function updateQuantity(index, quantity) {
    if (quantity <= 0) return;
    cart[index].quantity = parseInt(quantity, 10);
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

// Function to remove a product from the cart
function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

// Initialize badge when the page loads
updateCartBadge();

// Load cart display if on the cart page
if (window.location.pathname.includes("cart.html")) {
    displayCart();
}

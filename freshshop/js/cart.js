// Initialize cart from LocalStorage or an empty array
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Function to add a product to the cart
function addToCart(product) {
    const existingProduct = cart.find(item => item.id === product.id);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Product added to cart!");
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
                <td><button class="btn btn-danger" onclick="removeFromCart(${index})">Remove</button></td>
            </tr>
        `;
    });

    grandTotalElement.textContent = `$${grandTotal.toFixed(2)}`;
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

// Load cart display if on the cart page
if (window.location.pathname.includes("cart.html")) {
    displayCart();
}

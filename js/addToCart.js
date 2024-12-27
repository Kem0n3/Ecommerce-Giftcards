let cart = JSON.parse(localStorage.getItem('cart')) || [];

document.getElementById('cartIcon').addEventListener('click', toggleCart);
document.getElementById('addToCartBtn')?.addEventListener('click', addToCart);

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    updateCartDisplay();
});

function toggleCart() {
    document.querySelector('.cart-sidebar').classList.toggle('open');
}

function addToCart() {
    const productId = document.querySelector('input[name="id"]').value;
    const productName = document.querySelector('.product-detail h1').textContent;
    const selectedValue = document.querySelector('input[name="price"]:checked').value;
    const quantity = parseInt(document.getElementById('item-count').value);
    const productImage = document.querySelector('.product-image img').src;
    
    if (quantity === 0) return;

    const existingItem = cart.find(item => item.id === productId && item.value === selectedValue);
    
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({
            id: productId,
            name: productName,
            value: selectedValue,
            quantity: quantity,
            image: productImage
        });
    }
    
    saveCart();
    updateCartDisplay();
    updateCartCount();
    document.querySelector('.cart-sidebar').classList.add('open');
}

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById('cartCount').textContent = totalItems;
}

function updateCartDisplay() {
    const cartItems = document.querySelector('.cart-items');
    if (!cartItems) return;
    
    cartItems.innerHTML = '';
    
    cart.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-info">
                <h4>${item.name}</h4>
                <p>$${item.value}</p>
            </div>
            <div class="cart-item-controls">
                <div class="cart-quantity">
                    <button onclick="updateQuantity(${index}, -1)">-</button>
                    <input type="text" value="${item.quantity}" readonly>
                    <button onclick="updateQuantity(${index}, 1)">+</button>
                </div>
                <button class="delete-item" onclick="removeItem(${index})">×</button>
            </div>
        `;
        cartItems.appendChild(itemElement);
    });
    
    updateCartTotal();
}

function updateQuantity(index, change) {
    cart[index].quantity += change;
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    saveCart();
    updateCartDisplay();
    updateCartCount();
}

function removeItem(index) {
    cart.splice(index, 1);
    saveCart();
    updateCartDisplay();
    updateCartCount();
}

function updateCartTotal() {
    const total = cart.reduce((sum, item) => sum + (item.value * item.quantity), 0);
    const cartTotal = document.querySelector('.cart-total');
    if (!cartTotal) return;
    
    cartTotal.innerHTML = `
        <h3>Total: $${total.toFixed(2)}</h3>
        <button class="checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
    `;
}
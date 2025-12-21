import { STORAGE_KEYS } from './constants.js';

/**
 * CartManager - Manages shopping cart operations
 */
export class CartManager {
    constructor() {
        this.cart = this.loadCart();
    }

    /**
     * Load cart from localStorage
     */
    loadCart() {
        const cartData = localStorage.getItem(STORAGE_KEYS.CART);
        return cartData ? JSON.parse(cartData) : {};
    }

    /**
     * Save cart to localStorage
     */
    saveCart() {
        localStorage.setItem(STORAGE_KEYS.CART, JSON.stringify(this.cart));
    }

    /**
     * Add item to cart
     */
    addItem(id, name, price) {
        if (this.cart[id]) {
            this.cart[id].quantity += 1;
        } else {
            this.cart[id] = { id, name, price, quantity: 1 };
        }
        this.saveCart();
        return this.cart[id];
    }

    /**
     * Update item quantity
     */
    updateQuantity(id, quantity) {
        if (quantity <= 0) {
            return this.removeItem(id);
        }
        if (this.cart[id]) {
            this.cart[id].quantity = quantity;
            this.saveCart();
        }
        return this.cart[id];
    }

    /**
     * Remove item from cart
     */
    removeItem(id) {
        delete this.cart[id];
        this.saveCart();
        return true;
    }

    /**
     * Get cart total
     */
    getTotal() {
        return Object.values(this.cart).reduce(
            (total, item) => total + (item.price * item.quantity),
            0
        );
    }

    /**
     * Get item count
     */
    getItemCount() {
        return Object.values(this.cart).reduce(
            (count, item) => count + item.quantity,
            0
        );
    }

    /**
     * Clear cart
     */
    clear() {
        this.cart = {};
        this.saveCart();
        localStorage.removeItem(STORAGE_KEYS.PAYMENT_AMOUNT);
    }

    /**
     * Get all items
     */
    getItems() {
        return this.cart;
    }
}

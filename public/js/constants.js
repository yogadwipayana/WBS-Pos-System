// Storage Keys Constants
export const STORAGE_KEYS = {
    CART: 'wbs_cart',
    PAYMENT_AMOUNT: 'wbs_payment_amount',
    ORDER_NUMBER: 'wbs_order_number'
};

// API Endpoints
export const API_ENDPOINTS = {
    ORDERS: '/api/order',
    ADMIN_ORDERS: '/api/admin/orders',
    ADMIN_ORDER_STATUS: (orderNumber) => `/api/admin/orders/${orderNumber}/status`
};

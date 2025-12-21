/**
 * Format number as Indonesian Rupiah
 */
export function formatCurrency(amount) {
    return `Rp${parseInt(amount).toLocaleString('id-ID')}`;
}

/**
 * Show modal with animation
 */
export function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.remove('hidden');
    requestAnimationFrame(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
    });
}

/**
 * Hide modal with animation
 */
export function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.classList.add('opacity-0');
    modal.classList.remove('opacity-100');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

/**
 * Show loading indicator
 */
export function showLoader(loaderId = 'loader') {
    const loader = document.getElementById(loaderId);
    if (loader) loader.classList.remove('hidden');
}

/**
 * Hide loading indicator
 */
export function hideLoader(loaderId = 'loader') {
    const loader = document.getElementById(loaderId);
    if (loader) loader.classList.add('hidden');
}

/**
 * Show toast notification
 */
export function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-xl shadow-lg z-50 ${type === 'error' ? 'bg-red-500' :
            type === 'success' ? 'bg-green-500' :
                'bg-blue-500'
        } text-white`;
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

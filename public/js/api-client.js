import { showLoader, hideLoader } from './ui-helpers.js';

/**
 * Fetch with error handling and loading state
 */
export async function fetchWithErrorHandling(url, options = {}) {
    try {
        showLoader();
        const response = await fetch(url, options);

        if (!response.ok) {
            throw new Error(`HTTP Error ${response.status}: ${response.statusText}`);
        }

        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    } finally {
        hideLoader();
    }
}

/**
 * POST request helper
 */
export async function post(url, data) {
    return fetchWithErrorHandling(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(data)
    });
}

/**
 * PUT request helper
 */
export async function put(url, data) {
    return fetchWithErrorHandling(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(data)
    });
}

/**
 * GET request helper
 */
export async function get(url) {
    return fetchWithErrorHandling(url);
}

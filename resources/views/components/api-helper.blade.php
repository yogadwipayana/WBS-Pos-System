<script>
// API Helper with CSRF protection and error handling
window.apiHelper = {
    // Get CSRF token
    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    },

    // Fetch wrapper with error handling
    async fetch(url, options = {}) {
        // Add CSRF token to headers
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': this.getCsrfToken(),
            ...options.headers
        };

        try {
            const response = await fetch(url, {
                ...options,
                headers
            });

            const data = await response.json();

            if (!response.ok) {
                throw {
                    status: response.status,
                    message: data.message || 'Request failed',
                    errors: data.errors || null
                };
            }

            return { success: true, data };
        } catch (error) {
            console.error('API Error:', error);
            
            // Network error
            if (error instanceof TypeError) {
                return {
                    success: false,
                    message: 'Network error. Please check your connection.',
                    error
                };
            }

            // API error
            return {
                success: false,
                message: error.message || 'An error occurred',
                status: error.status,
                errors: error.errors,
                error
            };
        }
    },

    // POST request
    async post(url, data) {
        return this.fetch(url, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    },

    // GET request
    async get(url) {
        return this.fetch(url, {
            method: 'GET'
        });
    },

    // PUT request
    async put(url, data) {
        return this.fetch(url, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    },

    // DELETE request
    async delete(url) {
        return this.fetch(url, {
            method: 'DELETE'
        });
    },

    // Show error message
    showError(message, errors = null) {
        let errorHtml = `<div class="fixed top-4 right-4 z-50 max-w-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-lg animate-slide-in">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <div class="flex-1">
                    <p class="font-semibold mb-1">Error</p>
                    <p class="text-sm">${message}</p>`;
        
        if (errors) {
            errorHtml += '<ul class="mt-2 text-xs list-disc list-inside">';
            Object.values(errors).forEach(error => {
                if (Array.isArray(error)) {
                    error.forEach(err => errorHtml += `<li>${err}</li>`);
                } else {
                    errorHtml += `<li>${error}</li>`;
                }
            });
            errorHtml += '</ul>';
        }
        
        errorHtml += `</div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>`;
        
        const div = document.createElement('div');
        div.innerHTML = errorHtml;
        document.body.appendChild(div.firstElementChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            div.firstElementChild?.remove();
        }, 5000);
    },

    // Show success message
    showSuccess(message) {
        const successHtml = `<div class="fixed top-4 right-4 z-50 max-w-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-lg animate-slide-in">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">
                    <p class="font-semibold mb-1">Success</p>
                    <p class="text-sm">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>`;
        
        const div = document.createElement('div');
        div.innerHTML = successHtml;
        document.body.appendChild(div.firstElementChild);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            div.firstElementChild?.remove();
        }, 3000);
    },

    // Show loading indicator
    showLoading(button, originalText = 'Loading...') {
        button.disabled = true;
        button.dataset.originalText = button.textContent;
        button.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>${originalText}`;
    },

    // Hide loading indicator
    hideLoading(button) {
        button.disabled = false;
        button.textContent = button.dataset.originalText || 'Submit';
    }
};

// Add animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>

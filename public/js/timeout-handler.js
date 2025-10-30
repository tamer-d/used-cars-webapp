class TimeoutHandler {
    constructor() {
        this.setupAjaxInterceptor();
        this.setupFetchInterceptor();
    }
    
    setupAjaxInterceptor() {

        if (typeof $ !== 'undefined') {
            $(document).ajaxError((event, xhr, settings, thrownError) => {
                if (xhr.status === 408 || xhr.responseJSON?.error === 'timeout') {
                    this.showTimeoutModal();
                }
            });
        }
    }
    
    setupFetchInterceptor() {

        const originalFetch = window.fetch;
        window.fetch = async (...args) => {
            try {
                const response = await originalFetch(...args);
                
                if (response.status === 408) {
                    const data = await response.json();
                    if (data.error === 'timeout') {
                        this.showTimeoutModal();
                        return;
                    }
                }
                
                return response;
            } catch (error) {
                if (error.message.includes('timeout') || error.message.includes('execution time')) {
                    this.showTimeoutModal();
                    return;
                }
                throw error;
            }
        };
    }
    
    showTimeoutModal() {

        const modal = this.createModal();
        document.body.appendChild(modal);
        

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }
    
    createModal() {
        const modal = document.createElement('div');
        modal.className = 'timeout-modal';
        modal.innerHTML = `
            <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 timeout-overlay">
                <div class="min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 text-center max-w-md w-full transform transition-all duration-300 scale-95 opacity-0 timeout-content">
                        <div class="mb-6">
                            <div class="mx-auto w-20 h-20 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Temps d'exécution dépassé</h2>
                        <p class="text-gray-600 mb-6">La requête a pris trop de temps à s'exécuter. Veuillez réessayer.</p>
                        
                        <div class="space-y-3">
                            <button onclick="timeoutHandler.reloadPage()" class="w-full bg-blue-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-600 transition-colors">
                                Recharger la page
                            </button>
                            <button onclick="timeoutHandler.closeModal()" class="w-full bg-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-400 transition-colors">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        return modal;
    }
    
    reloadPage() {
        window.location.reload();
    }
    
    closeModal() {
        const modal = document.querySelector('.timeout-modal');
        if (modal) {
            modal.remove();
        }
    }
}

const timeoutHandler = new TimeoutHandler();

// CSS pour les animations
const style = document.createElement('style');
style.textContent = `
    .timeout-modal.show .timeout-content {
        transform: scale(1);
        opacity: 1;
    }
    
    .timeout-modal .timeout-content {
        transition: all 0.3s ease-out;
    }
`;
document.head.appendChild(style);
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeout - Temps d'exécution dépassé</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div class="relative z-10 max-w-md w-full">
        <div class="glass-effect rounded-2xl shadow-2xl p-8 text-center fade-in">
            <!-- Icon -->
            <div class="mb-6">
                <div class="mx-auto w-20 h-20 bg-red-500 rounded-full flex items-center justify-center pulse-animation">
                    <i class="fas fa-clock text-white text-3xl"></i>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-white mb-4">
                Temps d'exécution dépassé
            </h1>

            <!-- Message -->
            <p class="text-gray-200 mb-6 leading-relaxed">
                La requête a pris trop de temps à s'exécuter. Cela peut être dû à une surcharge temporaire du serveur ou
                à une connexion lente.
            </p>

            <!-- Progress bar animation -->
            <div class="mb-6">
                <div class="w-full bg-gray-300 rounded-full h-2 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-red-400 to-red-600 rounded-full animate-pulse"></div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <button onclick="reloadPage()"
                    class="w-full bg-white text-gray-800 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-redo-alt mr-2"></i>
                    Recharger la page
                </button>

                <button onclick="goBack()"
                    class="w-full bg-transparent border-2 border-white text-white font-semibold py-3 px-6 rounded-lg hover:bg-white hover:text-gray-800 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </button>
            </div>

            <!-- Additional info -->
            <div class="mt-6 pt-4 border-t border-gray-300">
                <p class="text-sm text-gray-300">
                    <i class="fas fa-info-circle mr-1"></i>
                    Si le problème persiste, contactez le support technique
                </p>
            </div>
        </div>
    </div>

    <script>
        function reloadPage() {
            // Animation de chargement
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Rechargement...';
            button.disabled = true;

            // Recharger après une courte pause pour l'animation
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }

        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }

        // Auto-reload après 30 secondes
        let countdown = 30;
        const countdownInterval = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                reloadPage();
            }
        }, 1000);

        // Gestion des touches clavier
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                reloadPage();
            } else if (e.key === 'Escape') {
                goBack();
            }
        });
    </script>
</body>

</html>

<?php
// Variables attendues : $pageTitle (string), $currentPage (string)
$pageTitle = $pageTitle ?? 'Intranet M2L';
$currentPage = $currentPage ?? '';
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'Segoe UI', 'system-ui', 'sans-serif'] },
                animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
                keyframes: { fadeIn: { '0%': { opacity: '0', transform: 'translateY(-8px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } } }
            }
        }
    }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .nav-active { @apply bg-white/20 text-white; }
            .input-base { @apply w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50 transition-all text-sm; }
            .label-base { @apply block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5; }
            .btn-primary { @apply flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-600 to-red-500 text-white py-3 px-6 rounded-xl font-semibold hover:from-red-700 hover:to-red-600 transition-all shadow-lg shadow-red-100 hover:shadow-red-200 hover:-translate-y-0.5 transform text-sm; }
            .btn-success { @apply flex items-center justify-center gap-2 w-full bg-gradient-to-r from-green-600 to-green-500 text-white py-3 px-6 rounded-xl font-semibold hover:from-green-700 hover:to-green-600 transition-all shadow-lg shadow-green-100 hover:shadow-green-200 hover:-translate-y-0.5 transform text-sm; }
            .card { @apply bg-white rounded-2xl shadow-sm border border-gray-100; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans antialiased">

<!-- ===== NAVBAR ===== -->
<nav class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 shadow-lg sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">

            <!-- Brand -->
            <a href="/ProjetM2L/pages/acceuil.php" class="flex items-center gap-3 group">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all">
                    <img src="/ProjetM2L/asset/intra.png" alt="Logo" class="w-5 h-5 object-contain">
                </div>
                <span class="font-bold text-white text-lg hidden sm:block tracking-tight">Intranet M2L</span>
            </a>

            <!-- Desktop nav -->
            <div class="hidden md:flex items-center gap-1">
                <a href="/ProjetM2L/pages/acceuil.php" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all text-white/85 hover:text-white hover:bg-white/15 <?= $currentPage === 'acceuil' ? 'bg-white/20 text-white' : '' ?>">
                    <i class="fas fa-home text-xs"></i> Accueil
                </a>
                <a href="/ProjetM2L/pages/listes.php" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all text-white/85 hover:text-white hover:bg-white/15 <?= $currentPage === 'listes' ? 'bg-white/20 text-white' : '' ?>">
                    <i class="fas fa-users text-xs"></i> Collaborateurs
                </a>
                <a href="/ProjetM2L/pages/profil.php" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all text-white/85 hover:text-white hover:bg-white/15 <?= $currentPage === 'profil' ? 'bg-white/20 text-white' : '' ?>">
                    <i class="fas fa-user-circle text-xs"></i> Mon profil
                </a>
                <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                <a href="/ProjetM2L/pages/form_categorie.php" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all text-white/85 hover:text-white hover:bg-white/15 <?= $currentPage === 'categories' ? 'bg-white/20 text-white' : '' ?>">
                    <i class="fas fa-tags text-xs"></i> Catégories
                </a>
                <?php endif; ?>
                <div class="w-px h-5 bg-white/30 mx-2"></div>
                <a href="/ProjetM2L/pages/deconnexion.php" class="flex items-center gap-2 bg-white text-red-600 hover:bg-red-50 px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm">
                    <i class="fas fa-right-from-bracket text-xs"></i> Déconnexion
                </a>
            </div>

            <!-- Mobile hamburger -->
            <button @click="open = !open" class="md:hidden text-white p-2 rounded-xl hover:bg-white/20 transition-all">
                <i class="fas fa-bars text-base" x-show="!open"></i>
                <i class="fas fa-xmark text-base" x-show="open" style="display:none"></i>
            </button>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden pb-4 border-t border-white/20 mt-1 pt-3 space-y-1" style="display:none">
            <a href="/ProjetM2L/pages/acceuil.php" class="flex items-center gap-3 text-white hover:bg-white/15 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
                <i class="fas fa-home w-4 text-center"></i> Accueil
            </a>
            <a href="/ProjetM2L/pages/listes.php" class="flex items-center gap-3 text-white hover:bg-white/15 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
                <i class="fas fa-users w-4 text-center"></i> Collaborateurs
            </a>
            <a href="/ProjetM2L/pages/profil.php" class="flex items-center gap-3 text-white hover:bg-white/15 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
                <i class="fas fa-user-circle w-4 text-center"></i> Mon profil
            </a>
            <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
            <a href="/ProjetM2L/pages/form_categorie.php" class="flex items-center gap-3 text-white hover:bg-white/15 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
                <i class="fas fa-tags w-4 text-center"></i> Catégories
            </a>
            <?php endif; ?>
            <a href="/ProjetM2L/pages/deconnexion.php" class="flex items-center gap-3 text-white hover:bg-white/15 px-4 py-2.5 rounded-xl text-sm font-medium transition-all">
                <i class="fas fa-right-from-bracket w-4 text-center"></i> Déconnexion
            </a>
        </div>
    </div>
</nav>
<main class="flex-1">

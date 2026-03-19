<?php
require_once '../src/auth_check.php';
require_once '../src/database.php';
require_once '../src/collaborateur.php';
$pageTitle   = 'Accueil - Intranet M2L';
$currentPage = 'acceuil';
require_once '../includes/header_connected.php';
?>

<!-- Hero banner -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-6 py-8 flex items-center gap-4">
        <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-building text-red-500 text-lg"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Bonjour, <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-400"><?= htmlspecialchars($_SESSION['user']['prenom'] ?? 'bienvenu') ?>&nbsp;!</span>
            </h1>
            <p class="text-gray-400 text-sm mt-1">La plate-forme collaborative de l&#39;entreprise M2L</p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-6 py-8">

    <!-- Section header -->
    <div class="mb-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Collaborateur du moment</p>
        <h2 class="text-xl font-bold text-gray-900">Avez-vous dit bonjour ?</h2>
    </div>

    <!-- Collaborator card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all">
        <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-pink-500"></div>
        <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start gap-6">
            <img src="../<?= htmlspecialchars($photo) ?>" alt="Photo"
                 class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover bg-gray-100 border-2 border-gray-100 flex-shrink-0">
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-start gap-3 mb-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($prenom . ' ' . $nom) ?></h3>
                        <p class="text-gray-400 text-sm flex items-center gap-1.5 mt-0.5">
                            <i class="fas fa-location-dot text-xs"></i>
                            <?= htmlspecialchars($ville) ?>, <?= htmlspecialchars($pays) ?>
                        </p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="bg-indigo-50 text-indigo-600 text-xs font-semibold px-3 py-1.5 rounded-full border border-indigo-100">
                            <?= htmlspecialchars($profession) ?>
                        </span>
                        <span class="text-gray-400 text-xs"><?= $age ?> ans</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="flex items-center gap-3 bg-blue-50/60 rounded-xl px-4 py-3">
                        <i class="fas fa-envelope text-blue-400 text-sm w-4 text-center"></i>
                        <span class="text-sm text-gray-700 truncate"><?= htmlspecialchars($email) ?></span>
                    </div>
                    <div class="flex items-center gap-3 bg-emerald-50/60 rounded-xl px-4 py-3">
                        <i class="fas fa-phone text-emerald-400 text-sm w-4 text-center"></i>
                        <span class="text-sm text-gray-700"><?= htmlspecialchars($telephone) ?></span>
                    </div>
                    <div class="flex items-center gap-3 bg-amber-50/60 rounded-xl px-4 py-3">
                        <i class="fas fa-birthday-cake text-amber-400 text-sm w-4 text-center"></i>
                        <span class="text-sm text-gray-700"><?= htmlspecialchars($date_de_naissance) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center mt-4">
        <button onclick="location.reload()"
                class="flex items-center gap-2 bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 hover:text-gray-800 px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm hover:shadow-md">
            👋 Dire bonjour à quelqu&#39;un d&#39;autre
        </button>
    </div>

    <!-- Quick actions -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="./listes.php"
           class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-red-100 transition-all group">
            <div class="w-10 h-10 bg-red-50 group-hover:bg-red-100 rounded-xl flex items-center justify-center mb-3 transition-colors">
                <i class="fas fa-users text-red-500"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800 group-hover:text-red-600 transition-colors">Tous les collaborateurs</p>
            <p class="text-xs text-gray-400 mt-1">Parcourir l&#39;annuaire complet</p>
        </a>
        <a href="./profil.php"
           class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-indigo-100 transition-all group">
            <div class="w-10 h-10 bg-indigo-50 group-hover:bg-indigo-100 rounded-xl flex items-center justify-center mb-3 transition-colors">
                <i class="fas fa-user-pen text-indigo-500"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">Mon profil</p>
            <p class="text-xs text-gray-400 mt-1">Modifier mes informations</p>
        </a>
        <a href="./form_categorie.php"
           class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-emerald-100 transition-all group">
            <div class="w-10 h-10 bg-emerald-50 group-hover:bg-emerald-100 rounded-xl flex items-center justify-center mb-3 transition-colors">
                <i class="fas fa-tags text-emerald-500"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Cat&#233;gories</p>
            <p class="text-xs text-gray-400 mt-1">G&#233;rer les cat&#233;gories</p>
        </a>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

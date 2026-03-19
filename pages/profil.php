<?php
require_once '../src/auth_check.php';
require_once '../src/database.php';
require_once '../src/modifier_profil.php';
$pageTitle   = 'Mon profil - Intranet M2L';
$currentPage = 'profil';
require_once '../includes/header_connected.php';
?>

<!-- Page header -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-2xl mx-auto px-6 py-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-user-pen text-red-500"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mon profil</h1>
            <p class="text-gray-500 text-sm">Modifiez vos informations personnelles</p>
        </div>
    </div>
</div>

<div class="max-w-2xl mx-auto px-6 py-8 space-y-6">

    <!-- Success message -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">
        <i class="fas fa-circle-check text-lg flex-shrink-0 mt-0.5"></i>
        <div>
            <p class="font-semibold text-sm">Profil mis &#224; jour</p>
            <p class="text-xs text-green-600 mt-0.5">Vos informations ont bien &#233;t&#233; enregistr&#233;es.</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Personal info card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-id-card text-red-500 text-sm"></i>
            </div>
            <h2 class="font-semibold text-gray-900">Informations personnelles</h2>
        </div>
        <form action="../src/modifier_profil.php" method="POST" class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Civilit&#233;</label>
                    <div class="relative">
                        <select name="civilite" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm appearance-none">
                            <option value="M." <?= ($_SESSION['user']['civilite'] ?? '') === 'M.' ? 'selected' : '' ?>>M.</option>
                            <option value="Mme" <?= ($_SESSION['user']['civilite'] ?? '') === 'Mme' ? 'selected' : '' ?>>Mme</option>
                            <option value="Autre" <?= ($_SESSION['user']['civilite'] ?? '') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Pr&#233;nom</label>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($_SESSION['user']['prenom'] ?? '') ?>" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($_SESSION['user']['nom'] ?? '') ?>" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Adresse email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400 text-sm"></i>
                    </div>
                    <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" required
                           class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">T&#233;l&#233;phone</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400 text-sm"></i>
                    </div>
                    <input type="tel" name="telephone" value="<?= htmlspecialchars($_SESSION['user']['telephone'] ?? '') ?>" required
                           class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Ville</label>
                    <input type="text" name="ville" value="<?= htmlspecialchars($_SESSION['user']['ville'] ?? '') ?>" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Pays</label>
                    <input type="text" name="pays" value="<?= htmlspecialchars($_SESSION['user']['pays'] ?? '') ?>" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>
            <div class="pt-2">
                <button type="submit"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-green-600 to-green-500 text-white py-3 px-6 rounded-xl font-semibold hover:from-green-700 hover:to-green-600 transition-all shadow-lg shadow-green-100 text-sm">
                    <i class="fas fa-floppy-disk"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

    <!-- Password card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-lock text-orange-500 text-sm"></i>
            </div>
            <div>
                <h2 class="font-semibold text-gray-900">Changer le mot de passe</h2>
                <p class="text-xs text-gray-400">Optionnel &mdash; laissez vide pour ne pas modifier</p>
            </div>
        </div>
        <form action="../src/modifier_profil.php" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Ancien mot de passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                    </div>
                    <input type="password" name="ancien_mdp" placeholder="Votre mot de passe actuel"
                           class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Nouveau mot de passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-key text-gray-400 text-sm"></i>
                    </div>
                    <input type="password" name="nouveau_mdp" placeholder="Nouveau mot de passe"
                           class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all text-sm">
                </div>
            </div>
            <div class="pt-2">
                <button type="submit"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-orange-500 to-orange-400 text-white py-3 px-6 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-500 transition-all shadow-lg shadow-orange-100 text-sm">
                    <i class="fas fa-lock"></i> Changer le mot de passe
                </button>
            </div>
        </form>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>

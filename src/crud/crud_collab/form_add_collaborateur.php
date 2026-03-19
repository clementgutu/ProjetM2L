<?php
require_once '../../auth/admin_check.php';
$pageTitle   = 'Ajouter un collaborateur - Intranet M2L';
$currentPage = 'listes';
require_once '../../../includes/header_connected.php';

$errors = [
    'champs'       => 'Tous les champs obligatoires doivent être remplis.',
    'email'        => 'Adresse email invalide.',
    'mdp'          => 'Le mot de passe doit contenir au moins 8 caractères.',
    'email_existe' => 'Cette adresse email est déjà utilisée.',
    'serveur'      => 'Erreur serveur, veuillez réessayer.',
];
$error = isset($_GET['error']) ? ($errors[$_GET['error']] ?? null) : null;
?>

<!-- Page header -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-2xl mx-auto px-6 py-6 flex items-center gap-3">
        <a href="/ProjetM2L/pages/listes.php" class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-all text-gray-500">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Ajouter un collaborateur</h1>
            <p class="text-gray-500 text-sm">Remplissez les informations du nouveau collaborateur</p>
        </div>
    </div>
</div>

<div class="max-w-2xl mx-auto px-6 py-8">

    <?php if ($error): ?>
    <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6">
        <i class="fas fa-circle-exclamation text-lg flex-shrink-0 mt-0.5"></i>
        <p class="text-sm font-medium"><?= htmlspecialchars($error) ?></p>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-plus text-red-500 text-sm"></i>
            </div>
            <h2 class="font-semibold text-gray-900">Informations du collaborateur</h2>
        </div>

        <form action="add_collaborateur.php" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Civilit&#233;</label>
                    <div class="relative">
                        <select name="civilite" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm appearance-none">
                            <option value="M.">M.</option>
                            <option value="Mme">Mme</option>
                            <option value="Autre">Autre</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Pr&#233;nom *</label>
                    <input type="text" name="prenom" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Nom *</label>
                <input type="text" name="nom" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Email *</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Mot de passe * <span class="normal-case font-normal text-gray-400">(min. 8 caract&#232;res)</span></label>
                <input type="password" name="motdepasse" required minlength="8"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">T&#233;l&#233;phone *</label>
                <input type="tel" name="telephone" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Profession *</label>
                <input type="text" name="profession" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Date de naissance</label>
                <input type="date" name="date_de_naissance"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Ville</label>
                    <input type="text" name="ville"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Pays</label>
                    <input type="text" name="pays"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-600 to-red-500 text-white py-3 px-6 rounded-xl font-semibold hover:from-red-700 hover:to-red-600 transition-all shadow-lg shadow-red-100 text-sm">
                    <i class="fas fa-user-plus"></i> Ajouter le collaborateur
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../../includes/footer.php'; ?>

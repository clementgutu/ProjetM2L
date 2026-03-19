<?php
require_once '../../admin_check.php';
require_once '../../database.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: /ProjetM2L/pages/listes.php');
    exit;
}

$stmt = $database->prepare("SELECT * FROM collaborateurs WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$collab = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$collab) {
    header('Location: /ProjetM2L/pages/listes.php');
    exit;
}

$pageTitle   = 'Modifier collaborateur - Intranet M2L';
$currentPage = 'listes';
require_once '../../../includes/header_connected.php';

$errors = [
    'champs'       => 'Tous les champs obligatoires doivent être remplis.',
    'email'        => 'Adresse email invalide.',
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
            <h1 class="text-2xl font-bold text-gray-900">Modifier le collaborateur</h1>
            <p class="text-gray-500 text-sm"><?= htmlspecialchars($collab['prenom'] . ' ' . $collab['nom']) ?></p>
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

    <?php if (isset($_GET['success'])): ?>
    <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6">
        <i class="fas fa-circle-check text-lg flex-shrink-0 mt-0.5"></i>
        <p class="text-sm font-medium">Collaborateur mis &#224; jour avec succ&#232;s.</p>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-pen text-blue-500 text-sm"></i>
            </div>
            <h2 class="font-semibold text-gray-900">Informations personnelles</h2>
        </div>

        <form action="edit_collaborateur.php" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <input type="hidden" name="id" value="<?= $collab['id'] ?>">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Civilit&#233;</label>
                    <div class="relative">
                        <select name="civilite" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm appearance-none">
                            <option value="M."   <?= $collab['civilite'] === 'M.'   ? 'selected' : '' ?>>M.</option>
                            <option value="Mme"  <?= $collab['civilite'] === 'Mme'  ? 'selected' : '' ?>>Mme</option>
                            <option value="Autre"<?= $collab['civilite'] === 'Autre'? 'selected' : '' ?>>Autre</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Pr&#233;nom *</label>
                    <input type="text" name="prenom" required
                           value="<?= htmlspecialchars($collab['prenom']) ?>"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Nom *</label>
                <input type="text" name="nom" required
                       value="<?= htmlspecialchars($collab['nom']) ?>"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Email *</label>
                <input type="email" name="email" required
                       value="<?= htmlspecialchars($collab['email']) ?>"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">T&#233;l&#233;phone *</label>
                <input type="tel" name="telephone" required
                       value="<?= htmlspecialchars($collab['telephone']) ?>"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Profession *</label>
                <input type="text" name="profession" required
                       value="<?= htmlspecialchars($collab['profession']) ?>"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Date de naissance</label>
                <input type="date" name="date_de_naissance"
                       value="<?= htmlspecialchars($collab['date_de_naissance'] ?? '') ?>"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Ville</label>
                    <input type="text" name="ville"
                           value="<?= htmlspecialchars($collab['ville'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Pays</label>
                    <input type="text" name="pays"
                           value="<?= htmlspecialchars($collab['pays'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-600 transition-all shadow-lg shadow-blue-100 text-sm">
                    <i class="fas fa-floppy-disk"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../../includes/footer.php'; ?>

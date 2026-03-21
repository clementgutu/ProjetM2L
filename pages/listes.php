<?php
require_once '../src/auth/auth_check.php';
require_once '../src/collaborateurs/filtre_collaborateurs.php';
$isAdmin     = ($_SESSION['user']['role'] ?? '') === 'admin';
$pageTitle   = 'Collaborateurs - Intranet M2L';
$currentPage = 'listes';
require_once '../includes/header_connected.php';

// Construction de la query string sans "page" pour la pagination
$qParams = $_GET;
unset($qParams['page']);
$baseQuery = http_build_query($qParams);
$baseQuery = $baseQuery ? '?' . $baseQuery . '&' : '?';
?>

<!-- Page header -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Annuaire des collaborateurs</h1>
            <p class="text-gray-500 text-sm mt-1">
                <?= $totalCollaborateurs ?> collaborateur<?= $totalCollaborateurs > 1 ? 's' : '' ?> au total
                &mdash; page <?= $page ?> / <?= $totalPages ?>
            </p>
        </div>
        <?php if ($isAdmin): ?>
        <a href="form_add_collaborateur.php"
           class="flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:from-red-700 hover:to-red-600 transition-all shadow-md shadow-red-100">
            <i class="fas fa-plus text-xs"></i> Ajouter
        </a>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="max-w-7xl mx-auto px-6 pt-5">
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3.5 rounded-2xl text-sm font-medium">
        <i class="fas fa-circle-check"></i>
        <?= $_GET['success'] === 'ajout' ? 'Collaborateur ajouté avec succès.' : 'Collaborateur supprimé avec succès.' ?>
    </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
<div class="max-w-7xl mx-auto px-6 pt-5">
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-2xl text-sm font-medium">
        <i class="fas fa-circle-exclamation"></i>
        Une erreur est survenue, veuillez réessayer.
    </div>
</div>
<?php endif; ?>

<!-- Search & filters -->
<div class="max-w-7xl mx-auto px-6 py-5">
    <form method="GET" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-48">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="search" name="recherche" placeholder="Nom, email, service..."
                           value="<?= htmlspecialchars($_GET['recherche'] ?? '') ?>"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50 transition-all text-sm">
                </div>
            </div>
            <div class="min-w-36">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Chercher par</label>
                <div class="relative">
                    <select name="categorie"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm appearance-none pr-8">
                        <option value="aucun"     <?= ($_GET['categorie'] ?? '') === 'aucun'     ? 'selected' : '' ?>>Tous champs</option>
                        <option value="nom"       <?= ($_GET['categorie'] ?? '') === 'nom'       ? 'selected' : '' ?>>Nom</option>
                        <option value="prenom"    <?= ($_GET['categorie'] ?? '') === 'prenom'    ? 'selected' : '' ?>>Pr&#233;nom</option>
                        <option value="profession"<?= ($_GET['categorie'] ?? '') === 'profession'? 'selected' : '' ?>>Service</option>
                        <option value="email"     <?= ($_GET['categorie'] ?? '') === 'email'     ? 'selected' : '' ?>>Email</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </div>
                </div>
            </div>
            <div class="min-w-36">
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Cat&#233;gorie</label>
                <div class="relative">
                    <select name="categorie_salarie"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all text-sm appearance-none pr-8">
                        <option value="aucun"      <?= ($_GET['categorie_salarie'] ?? '') === 'aucun'      ? 'selected' : '' ?>>Toutes</option>
                        <option value="cadre"      <?= ($_GET['categorie_salarie'] ?? '') === 'cadre'      ? 'selected' : '' ?>>Cadre</option>
                        <option value="technicien" <?= ($_GET['categorie_salarie'] ?? '') === 'technicien' ? 'selected' : '' ?>>Technicien</option>
                        <option value="ouvrier"    <?= ($_GET['categorie_salarie'] ?? '') === 'ouvrier'    ? 'selected' : '' ?>>Ouvrier</option>
                        <option value="employe"    <?= ($_GET['categorie_salarie'] ?? '') === 'employe'    ? 'selected' : '' ?>>Employ&#233;</option>
                        <option value="stagiaire"  <?= ($_GET['categorie_salarie'] ?? '') === 'stagiaire'  ? 'selected' : '' ?>>Stagiaire</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </div>
                </div>
            </div>
            <button type="submit"
                    class="flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:from-red-700 hover:to-red-600 transition-all shadow-md shadow-red-100">
                <i class="fas fa-search text-xs"></i> Rechercher
            </button>
            <?php if (!empty($_GET['recherche']) || (isset($_GET['categorie']) && $_GET['categorie'] !== 'aucun') || (isset($_GET['categorie_salarie']) && $_GET['categorie_salarie'] !== 'aucun')): ?>
            <a href="./listes.php"
               class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl font-medium text-sm transition-all">
                <i class="fas fa-xmark text-xs"></i> R&#233;initialiser
            </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Results grid -->
<div class="max-w-7xl mx-auto px-6 pb-6">
    <?php if (empty($collaborateurs)): ?>
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-user-slash text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-gray-600 font-semibold mb-1">Aucun r&#233;sultat</h3>
        <p class="text-gray-400 text-sm">Essayez de modifier vos crit&#232;res de recherche.</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php foreach ($collaborateurs as $c):
            $naissance = new DateTime($c['date_de_naissance']);
            $age = (new DateTime())->diff($naissance)->y;
        ?>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-red-100 transition-all overflow-hidden group">
            <div class="h-1 bg-gradient-to-r from-red-600 to-red-400"></div>
            <div class="p-5">
                <div class="flex items-start gap-4 mb-4">
                    <img src="../<?= htmlspecialchars($c['photo']) ?>" alt="Photo"
                         class="w-14 h-14 rounded-xl object-cover bg-gray-100 flex-shrink-0 border border-gray-100">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-gray-900 text-base leading-snug">
                                <?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?>
                                <span class="text-gray-400 text-xs font-normal">(<?= $age ?> ans)</span>
                            </h3>
                            <?php if ($isAdmin): ?>
                            <div class="flex items-center gap-1 flex-shrink-0">
                                <a href="form_edit_collaborateur.php?id=<?= $c['id'] ?>"
                                   title="Modifier"
                                   class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 transition-all">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="../src/crud/crud_collab/delete_collaborateur.php"
                                      onsubmit="return confirm('Supprimer <?= htmlspecialchars(addslashes($c['prenom'] . ' ' . $c['nom'])) ?> ?')">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                    <button type="submit" title="Supprimer"
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-all">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                            <?php endif; ?>
                        </div>
                        <span class="inline-block bg-red-50 text-red-600 text-xs font-semibold px-2.5 py-1 rounded-full mt-1.5 border border-red-100">
                            <?= htmlspecialchars($c['profession']) ?>
                        </span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <i class="fas fa-location-dot text-red-400 w-4 text-center text-xs"></i>
                        <span><?= htmlspecialchars($c['ville']) ?>, <?= htmlspecialchars($c['pays']) ?></span>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <i class="fas fa-envelope text-red-400 w-4 text-center text-xs"></i>
                        <span class="truncate"><?= htmlspecialchars($c['email']) ?></span>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <i class="fas fa-phone text-red-400 w-4 text-center text-xs"></i>
                        <span><?= htmlspecialchars($c['telephone']) ?></span>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-gray-600">
                        <i class="fas fa-birthday-cake text-red-400 w-4 text-center text-xs"></i>
                        <span><?= htmlspecialchars($c['date_de_naissance']) ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
<div class="max-w-7xl mx-auto px-6 pb-10">
    <div class="flex items-center justify-center gap-1">
        <?php if ($page > 1): ?>
        <a href="<?= $baseQuery ?>page=<?= $page - 1 ?>"
           class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all text-sm">
            <i class="fas fa-chevron-left text-xs"></i>
        </a>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php if ($p === $page): ?>
            <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold text-sm shadow-sm">
                <?= $p ?>
            </span>
            <?php elseif ($p === 1 || $p === $totalPages || abs($p - $page) <= 1): ?>
            <a href="<?= $baseQuery ?>page=<?= $p ?>"
               class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all text-sm">
                <?= $p ?>
            </a>
            <?php elseif (abs($p - $page) === 2): ?>
            <span class="w-9 h-9 flex items-center justify-center text-gray-400 text-sm">…</span>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
        <a href="<?= $baseQuery ?>page=<?= $page + 1 ?>"
           class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all text-sm">
            <i class="fas fa-chevron-right text-xs"></i>
        </a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>

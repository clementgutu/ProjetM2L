<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Messages d'erreur d'inscription
$erreurs = [
    'csrf'         => "Requête invalide. Veuillez réessayer.",
    'champs'       => "Veuillez remplir tous les champs obligatoires.",
    'email'        => "L'adresse email saisie est invalide.",
    'mdp'          => "Le mot de passe doit contenir au moins 8 caractères.",
    'email_existe' => "Cette adresse email est déjà utilisée.",
    'serveur'      => "Une erreur serveur est survenue. Veuillez réessayer.",
];
$erreur_inscription = isset($_GET['error'], $erreurs[$_GET['error']]) ? $erreurs[$_GET['error']] : null;

$basePath    = './';
$pageTitle   = 'Inscription — Intranet M2L';
$navLinkHref = './pages/connexion.php';
$navLinkText = 'Se connecter';
$navLinkIcon = 'fa-right-to-bracket';
require_once 'includes/header_public.php';
?>

<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}
@keyframes floatA {
    0%,100% { transform: translateY(-40px) translateX(40px); }
    50%     { transform: translateY(-48px) translateX(36px) rotate(6deg); }
}
@keyframes floatB {
    0%,100% { transform: translateY(32px) translateX(-32px); }
    50%     { transform: translateY(40px) translateX(-28px); }
}
@keyframes floatC {
    0%,100% { transform: rotate(12deg) scale(1); }
    50%     { transform: rotate(20deg) scale(1.08); }
}
@keyframes alertSlide {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes spin { to { transform: rotate(360deg); } }

.anim-card   { animation: slideUp 0.55s cubic-bezier(.22,.68,0,1.2) both; }
.anim-panel  { animation: fadeIn  0.6s ease both; }
.shape-a     { animation: floatA  7s ease-in-out infinite; }
.shape-b     { animation: floatB  9s ease-in-out infinite; }
.shape-c     { animation: floatC  5s ease-in-out infinite; }
.alert-in    { animation: alertSlide .3s ease both; }

.spinner {
    display: inline-block;
    width: 17px; height: 17px;
    border: 2.5px solid rgba(255,255,255,.35);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .7s linear infinite;
    flex-shrink: 0;
}

.inp {
    width: 100%;
    background: #f9fafb;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    padding: 11px 14px;
    font-size: 14px;
    color: #111827;
    outline: none;
    box-sizing: border-box;
    transition: border-color .2s, box-shadow .2s, background .2s;
    font-family: inherit;
}
.inp::placeholder { color: #9ca3af; }
.inp:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,.15);
    background: #fff;
}
.inp-pl { padding-left: 44px; }
.inp-icon {
    position: absolute; left: 14px; top: 50%;
    transform: translateY(-50%);
    color: #9ca3af; font-size: 13px; pointer-events: none;
    transition: color .2s;
}
.inp-wrap:focus-within .inp-icon { color: #ef4444; }

.btn-submit {
    width: 100%; padding: 13px 20px;
    border-radius: 12px; font-weight: 600; font-size: 14px;
    cursor: pointer; border: none;
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: #fff;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: transform .15s, box-shadow .15s, opacity .15s;
    box-shadow: 0 4px 18px rgba(220,38,38,.35);
    font-family: inherit;
}
.btn-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(220,38,38,.45);
}
.btn-submit:active:not(:disabled) { transform: translateY(0); }
.btn-submit:disabled { opacity: .7; cursor: not-allowed; }

.pwd-toggle {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #9ca3af; padding: 4px; transition: color .2s;
}
.pwd-toggle:hover { color: #6b7280; }

label.lbl {
    display: block;
    font-size: 11px; font-weight: 600; color: #6b7280;
    text-transform: uppercase; letter-spacing: .05em;
    margin-bottom: 6px;
}
</style>

<div class="min-h-screen flex">

    <!-- ── Left panel ─────────────────────────── -->
    <div class="anim-panel hidden lg:flex lg:w-5/12 bg-gradient-to-br from-red-900 via-red-700 to-red-500 flex-col items-center justify-center p-12 relative overflow-hidden">
        <div class="shape-a absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full"></div>
        <div class="shape-b absolute bottom-0 left-0 w-64 h-64 bg-white/5  rounded-full"></div>
        <div class="shape-c absolute bottom-1/4 right-8 w-20 h-20 bg-white/10 rounded-2xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,.08),transparent_60%)]"></div>

        <div class="relative z-10 text-center">
            <div class="w-24 h-24 bg-white/20 rounded-3xl flex items-center justify-center mx-auto mb-8 backdrop-blur-sm border border-white/30 shadow-2xl">
                <img src="./asset/intra.png" alt="Logo" class="w-12 h-12 object-contain drop-shadow">
            </div>
            <h1 class="text-4xl font-bold text-white mb-3 tracking-tight">Intranet M2L</h1>
            <p class="text-red-100 text-sm mb-10 leading-relaxed">
                Rejoignez l'espace collaboratif<br>de votre entreprise.
            </p>
            <div class="space-y-3">
                <div class="flex items-center gap-3 text-red-100 text-sm bg-white/10 rounded-xl px-5 py-3 backdrop-blur-sm border border-white/10">
                    <i class="fas fa-users text-white w-5 text-center"></i>
                    <span>Annuaire des collaborateurs</span>
                </div>
                <div class="flex items-center gap-3 text-red-100 text-sm bg-white/10 rounded-xl px-5 py-3 backdrop-blur-sm border border-white/10">
                    <i class="fas fa-shield-halved text-white w-5 text-center"></i>
                    <span>Espace sécurisé et privé</span>
                </div>
                <div class="flex items-center gap-3 text-red-100 text-sm bg-white/10 rounded-xl px-5 py-3 backdrop-blur-sm border border-white/10">
                    <i class="fas fa-bolt text-white w-5 text-center"></i>
                    <span>Accès rapide à vos informations</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Right panel ────────────────────────── -->
    <div class="w-full lg:w-7/12 flex items-start justify-center p-6 pt-24 pb-10 overflow-y-auto bg-gray-50"
         x-data="{ showPwd: false, loading: false, submitForm(e) { this.loading = true; e.target.closest('form').submit(); } }">

        <div class="anim-card w-full max-w-md">

            <!-- Mobile logo -->
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center gap-3 bg-gradient-to-r from-red-700 to-red-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-red-200">
                    <img src="./asset/intra.png" alt="Logo" class="w-7 h-7">
                    <span class="font-bold text-lg">Intranet M2L</span>
                </div>
            </div>

            <div class="mb-7">
                <h2 class="text-3xl font-bold text-gray-900 mb-1">Créer un compte</h2>
                <p class="text-gray-400 text-sm">Remplissez le formulaire pour rejoindre l'intranet.</p>
            </div>

            <!-- Error alert -->
            <?php if (!empty($erreur_inscription)): ?>
            <div class="alert-in flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-xl text-sm mb-6">
                <i class="fas fa-circle-exclamation flex-shrink-0 mt-0.5"></i>
                <span><?= htmlspecialchars($erreur_inscription) ?></span>
            </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="src/inscription.php" method="POST" class="space-y-4" @submit.prevent="submitForm($event)">

                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <!-- Civilité + Date de naissance -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="lbl">Civilité</label>
                        <div class="relative">
                            <select name="civilite" required class="inp appearance-none pr-8">
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
                        <label class="lbl">Date de naissance</label>
                        <input type="date" name="date_de_naissance" required class="inp">
                    </div>
                </div>

                <!-- Prénom + Nom -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="lbl">Prénom</label>
                        <input type="text" name="prenom" placeholder="Prénom" required class="inp">
                    </div>
                    <div>
                        <label class="lbl">Nom</label>
                        <input type="text" name="nom" placeholder="Nom" required class="inp">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="lbl">Adresse email</label>
                    <div class="inp-wrap relative">
                        <i class="inp-icon fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="votre@email.com" required
                               class="inp inp-pl" autocomplete="email">
                    </div>
                </div>

                <!-- Mot de passe -->
                <div>
                    <label class="lbl">Mot de passe <span class="normal-case font-normal text-gray-400">(min. 8 caractères)</span></label>
                    <div class="inp-wrap relative">
                        <i class="inp-icon fas fa-lock"></i>
                        <input :type="showPwd ? 'text' : 'password'" name="motdepasse"
                               placeholder="••••••••" required minlength="8"
                               class="inp inp-pl pr-11" autocomplete="new-password">
                        <button type="button" class="pwd-toggle" @click="showPwd = !showPwd" tabindex="-1">
                            <i class="fas text-sm" :class="showPwd ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Profession -->
                <div>
                    <label class="lbl">Profession / Service</label>
                    <input type="text" name="profession" placeholder="Ex : Technicien, Marketing..." required class="inp">
                </div>

                <!-- Téléphone -->
                <div>
                    <label class="lbl">Téléphone</label>
                    <div class="inp-wrap relative">
                        <i class="inp-icon fas fa-phone"></i>
                        <input type="tel" name="telephone" placeholder="+33 6 00 00 00 00" required
                               class="inp inp-pl">
                    </div>
                </div>

                <!-- Ville + Pays -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="lbl">Ville</label>
                        <input type="text" name="ville" placeholder="Ville" required class="inp">
                    </div>
                    <div>
                        <label class="lbl">Pays</label>
                        <input type="text" name="pays" placeholder="Pays" required class="inp">
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit" class="btn-submit" :disabled="loading">
                        <template x-if="!loading">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-user-plus text-sm"></i>
                                Créer mon compte
                            </span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center gap-2">
                                <span class="spinner"></span>
                                Création en cours…
                            </span>
                        </template>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 font-medium">ou</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <p class="text-center text-gray-500 text-sm">
                Déjà un compte ?
                <a href="./pages/connexion.php" class="text-red-600 font-semibold hover:text-red-700 transition-colors hover:underline">
                    Se connecter
                </a>
            </p>
        </div>
    </div>
</div>

<footer class="fixed bottom-0 left-0 right-0 py-3 px-6 text-center lg:text-right pointer-events-none">
    <p class="text-gray-400 text-xs">&copy; <?= date('Y') ?> Intranet M2L — Tous droits réservés</p>
</footer>

</body>
</html>

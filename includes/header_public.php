<?php
// Variables attendues : $pageTitle, $basePath, $navLinkHref, $navLinkText, $navLinkIcon
$pageTitle   = $pageTitle   ?? 'Intranet M2L';
$basePath    = $basePath    ?? './';
$navLinkHref = $navLinkHref ?? '#';
$navLinkText = $navLinkText ?? '';
$navLinkIcon = $navLinkIcon ?? 'fa-arrow-right';
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
        theme: { extend: { fontFamily: { sans: ['Inter','Segoe UI','system-ui','sans-serif'] } } }
    }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .input-base { @apply w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50 transition-all text-sm; }
            .label-base { @apply block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5; }
            .btn-primary { @apply flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-600 to-red-500 text-white py-3.5 px-6 rounded-xl font-semibold hover:from-red-700 hover:to-red-600 transition-all shadow-lg shadow-red-100 hover:shadow-red-200 hover:-translate-y-0.5 transform text-sm cursor-pointer; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

<!-- Top bar -->
<div class="fixed top-0 left-0 right-0 z-50 px-6 py-4 flex items-center justify-between">
    <a href="<?= $basePath ?>pages/acceuil.php" class="flex items-center gap-2">
        <div class="w-9 h-9 bg-gradient-to-br from-red-600 to-red-500 rounded-xl flex items-center justify-center shadow-lg shadow-red-200">
            <img src="<?= $basePath ?>asset/intra.png" alt="Logo" class="w-5 h-5 object-contain">
        </div>
        <span class="font-bold text-gray-900 text-base">Intranet <span class="text-red-600">M2L</span></span>
    </a>
    <?php if (!empty($navLinkText)): ?>
    <a href="<?= htmlspecialchars($navLinkHref) ?>" class="flex items-center gap-2 bg-white border border-gray-200 text-gray-700 hover:text-red-600 hover:border-red-200 px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm hover:shadow-md">
        <i class="fas <?= $navLinkIcon ?> text-xs"></i> <?= htmlspecialchars($navLinkText) ?>
    </a>
    <?php endif; ?>
</div>

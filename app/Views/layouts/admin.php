<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin - Fikri Production') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <script>(function(){if(localStorage.getItem('darkMode')==='1'||(localStorage.getItem('darkMode')===null&&window.matchMedia('(prefers-color-scheme:dark)').matches))document.documentElement.classList.add('dark')})()</script>
    <style>
    .adm-nav::-webkit-scrollbar{width:3px}
    .adm-nav::-webkit-scrollbar-track{background:transparent}
    .adm-nav::-webkit-scrollbar-thumb{background:rgba(251,146,60,.35);border-radius:2px}
    .adm-nav::-webkit-scrollbar-thumb:hover{background:rgba(251,146,60,.65)}
    .adm-main::-webkit-scrollbar{width:6px}
    .adm-main::-webkit-scrollbar-track{background:#f3f4f6;border-radius:3px}
    .adm-main::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:3px}
    .adm-main::-webkit-scrollbar-thumb:hover{background:#f97316}
    .dark .adm-main::-webkit-scrollbar-track{background:#0f172a}
    .dark .adm-main::-webkit-scrollbar-thumb{background:#334155}
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex h-screen overflow-hidden">
    <?= $this->include('partials/sidebar_admin') ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        <?= $this->include('partials/navbar_admin') ?>

        <main class="adm-main flex-1 overflow-y-auto p-6">
            <?= $this->include('partials/flash_messages') ?>
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script src="<?= base_url('assets/js/preline.js') ?>"></script>
<script>function toggleDark(){document.documentElement.classList.toggle('dark');localStorage.setItem('darkMode',document.documentElement.classList.contains('dark')?'1':'0')}</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>

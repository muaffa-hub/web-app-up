<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login - Fikri Production') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script>(function(){if(localStorage.getItem('darkMode')==='1'||(localStorage.getItem('darkMode')===null&&window.matchMedia('(prefers-color-scheme:dark)').matches))document.documentElement.classList.add('dark')})()</script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold"><span class="text-orange-600">Fikri</span><span class="text-gray-800"> Production</span></h1>
            <p class="text-gray-500 text-sm mt-1">Toko & Jasa Print</p>
        </div>
        <?= $this->include('partials/flash_messages') ?>
        <?= $this->renderSection('content') ?>
    </div>
    <script src="<?= base_url('assets/js/preline.js') ?>"></script>
    <script>function toggleDark(){document.documentElement.classList.toggle('dark');localStorage.setItem('darkMode',document.documentElement.classList.contains('dark')?'1':'0')}</script>
</body>
</html>

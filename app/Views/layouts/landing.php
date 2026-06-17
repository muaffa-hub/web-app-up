<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Fikri Production') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <script>(function(){if(localStorage.getItem('darkMode')==='1'||(localStorage.getItem('darkMode')===null&&window.matchMedia('(prefers-color-scheme:dark)').matches))document.documentElement.classList.add('dark')})()</script>
</head>
<body class="bg-white min-h-screen flex flex-col">

<?= $this->include('partials/navbar_customer') ?>

<main class="flex-1">
    <?= $this->renderSection('content') ?>
</main>

<?= $this->include('partials/footer') ?>

<?= $this->include('partials/wa_button') ?>

<script src="<?= base_url('assets/js/preline.js') ?>"></script>
<script>function toggleDark(){document.documentElement.classList.toggle('dark');localStorage.setItem('darkMode',document.documentElement.classList.contains('dark')?'1':'0')}</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>

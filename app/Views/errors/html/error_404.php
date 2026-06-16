<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 – Halaman Tidak Ditemukan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script>(function(){if(localStorage.getItem('darkMode')==='1'||(localStorage.getItem('darkMode')===null&&window.matchMedia('(prefers-color-scheme:dark)').matches))document.documentElement.classList.add('dark')})()</script>
    <style>
    .err-float{animation:err-float 3s ease-in-out infinite}
    @keyframes err-float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center px-4">

    <div style="max-width:26rem;width:100%;text-align:center">

        <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-2.5 mb-10 justify-center">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="height:2.5rem;width:2.5rem;object-fit:contain">
            <span class="text-xl font-bold"><span class="text-orange-600">Fikri</span><span class="text-gray-900"> Production</span></span>
        </a>

        <div class="err-float mb-6" style="display:flex;align-items:center;justify-content:center">
            <svg style="width:120px;height:120px;color:#ea580c;opacity:.15" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18a8 8 0 110-16 8 8 0 010 16zm-1-5h2v2h-2v-2zm0-8h2v6h-2V7z"/>
            </svg>
        </div>

        <div class="font-extrabold text-gray-200 select-none" style="font-size:6rem;line-height:1;letter-spacing:-.04em;margin-bottom:-.5rem">404</div>

        <h1 class="text-2xl font-extrabold text-gray-900 mb-3 mt-4">Halaman Tidak Ditemukan</h1>

        <p class="text-gray-500 text-sm leading-relaxed mb-8">
            Halaman yang kamu cari tidak ada atau mungkin sudah dipindahkan.<br>Coba kembali ke beranda.
        </p>

        <div class="flex flex-col gap-3 items-center">
            <a href="<?= base_url('/') ?>"
               class="inline-flex items-center gap-2 bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-orange-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="<?= base_url('/catalog') ?>" class="text-sm text-orange-600 hover:underline">Lihat Katalog Produk</a>
        </div>

    </div>

</body>
</html>

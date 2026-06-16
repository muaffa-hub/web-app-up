<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance – Fikri Production</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script>(function(){if(localStorage.getItem('darkMode')==='1'||(localStorage.getItem('darkMode')===null&&window.matchMedia('(prefers-color-scheme:dark)').matches))document.documentElement.classList.add('dark')})()</script>
    <style>
    .maint-icon-ring{animation:maint-spin 12s linear infinite}
    .maint-dot{animation:maint-pulse 2s ease-in-out infinite}
    .maint-dot:nth-child(2){animation-delay:.3s}
    .maint-dot:nth-child(3){animation-delay:.6s}
    @keyframes maint-spin{to{transform:rotate(360deg)}}
    @keyframes maint-pulse{0%,100%{opacity:.3;transform:scale(.75)}50%{opacity:1;transform:scale(1)}}
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center px-4">

    <div style="max-width:28rem;width:100%;text-align:center">

        <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-2.5 mb-10 justify-center">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="height:2.5rem;width:2.5rem;object-fit:contain">
            <span class="text-xl font-bold"><span class="text-orange-600">Fikri</span><span class="text-gray-900"> Production</span></span>
        </a>

        <div style="margin-bottom:2rem;display:flex;align-items:center;justify-content:center">
            <div style="position:relative;width:96px;height:96px">
                <svg class="maint-icon-ring" style="position:absolute;inset:0;width:96px;height:96px;color:#ea580c;opacity:.18" fill="none" viewBox="0 0 96 96">
                    <circle cx="48" cy="48" r="44" stroke="currentColor" stroke-width="3" stroke-dasharray="12 8"/>
                </svg>
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center">
                    <?php if ($type === 'print'): ?>
                    <svg style="width:44px;height:44px;color:#ea580c" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <?php elseif ($type === 'produk'): ?>
                    <svg style="width:44px;height:44px;color:#ea580c" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    <?php else: ?>
                    <svg style="width:44px;height:44px;color:#ea580c" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <h1 class="text-2xl font-extrabold text-gray-900 mb-3">
            <?php if ($type === 'print'): ?>
                Layanan Print Sedang Maintenance
            <?php elseif ($type === 'produk'): ?>
                Layanan Produk Sedang Maintenance
            <?php else: ?>
                Website Sedang Maintenance
            <?php endif; ?>
        </h1>

        <?php if (!empty($message)): ?>
        <p class="text-gray-500 leading-relaxed mb-6"><?= esc($message) ?></p>
        <?php else: ?>
        <p class="text-gray-500 leading-relaxed mb-6">Kami sedang melakukan pemeliharaan sistem. Mohon tunggu sebentar, kami akan segera kembali.</p>
        <?php endif; ?>

        <div style="display:flex;align-items:center;justify-content:center;gap:.5rem;margin-bottom:2.5rem">
            <span class="maint-dot" style="width:8px;height:8px;background:#ea580c;border-radius:9999px;display:block"></span>
            <span class="maint-dot" style="width:8px;height:8px;background:#ea580c;border-radius:9999px;display:block"></span>
            <span class="maint-dot" style="width:8px;height:8px;background:#ea580c;border-radius:9999px;display:block"></span>
        </div>

        <?php if ($type !== 'website'): ?>
        <a href="<?= base_url('/') ?>"
           class="inline-flex items-center gap-2 bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-orange-700 transition-colors text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Kembali ke Beranda
        </a>
        <?php endif; ?>

        <?php if (!empty($store['no_whatsapp']) || !empty($store['instagram'])): ?>
        <div class="text-sm text-gray-400 mt-2">
            Butuh bantuan?
            <?php if (!empty($store['no_whatsapp'])): ?>
            <a href="https://wa.me/<?= esc($store['no_whatsapp']) ?>" target="_blank" rel="noopener noreferrer"
               class="text-green-600 font-semibold hover:underline">WhatsApp</a>
            <?php endif; ?>
            <?php if (!empty($store['no_whatsapp']) && !empty($store['instagram'])): ?>
            atau
            <?php endif; ?>
            <?php if (!empty($store['instagram'])): ?>
            <a href="https://instagram.com/<?= esc(ltrim($store['instagram'], '@')) ?>" target="_blank" rel="noopener noreferrer"
               class="text-pink-600 font-semibold hover:underline">Instagram</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

</body>
</html>

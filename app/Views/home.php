<?= $this->extend('layouts/landing') ?>
<?= $this->section('content') ?>

<!-- HERO -->
<style>
@keyframes blob-drift-1 {
    0%,100% { transform: translate(0,0) scale(1); }
    33%      { transform: translate(3rem,-2rem) scale(1.1); }
    66%      { transform: translate(-2rem,3rem) scale(0.95); }
}
@keyframes blob-drift-2 {
    0%,100% { transform: translate(0,0) scale(1); }
    33%      { transform: translate(-4rem,2rem) scale(1.08); }
    66%      { transform: translate(2rem,-3rem) scale(0.97); }
}
@keyframes blob-drift-3 {
    0%,100% { transform: translateX(-50%) scale(1); }
    50%      { transform: translateX(calc(-50% + 4rem)) scale(1.12); }
}
</style>
<section class="bg-white relative">
    <!-- Animated blobs -->
    <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none;z-index:0">
        <div style="position:absolute;top:-6rem;left:-6rem;width:36rem;height:36rem;background:rgba(251,146,60,0.28);border-radius:9999px;filter:blur(72px);animation:blob-drift-1 14s ease-in-out infinite"></div>
        <div style="position:absolute;bottom:-6rem;right:-4rem;width:38rem;height:38rem;background:rgba(249,115,22,0.22);border-radius:9999px;filter:blur(80px);animation:blob-drift-2 18s ease-in-out infinite"></div>
        <div style="position:absolute;top:35%;left:50%;width:52rem;height:20rem;background:rgba(253,186,116,0.18);border-radius:9999px;filter:blur(64px);animation:blob-drift-3 22s ease-in-out infinite"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative hero-pad" style="z-index:1">

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-orange-50 border border-orange-100 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-6 tracking-widest uppercase">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="" style="height:1rem;width:1rem;object-fit:contain">
            Fikri Production
        </div>

        <!-- Headline — max-width diperlebar agar teks muat 2 baris bersih -->
        <h1 class="font-extrabold text-gray-900 leading-tight mb-4 mx-auto border-b-4 border-orange-600 pb-2"
            style="font-size:clamp(1.625rem,5vw,3.25rem);letter-spacing:-0.025em;max-width:56rem">
            Dukung UMKM Sekolah Lewat<br>
            <span class="text-orange-600">Unit Produksi SMK IT Ihsanul Fikri</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-gray-500 leading-relaxed mx-auto mb-10"
           style="font-size:1.0625rem;max-width:30rem">
            Platform resmi Unit Produksi Fikri Production SMK IT Ihsanul Fikri untuk siswa, guru, dan staf. Pesan produk atau jasa print, bayar saat ambil.
        </p>

        <!-- Product Fan – desktop (sm+) -->
        <div class="hero-fan-d">

            <div class="fan-card" style="transform:rotate(-16deg) translateY(22px);margin-right:-20px;z-index:1">
                <div class="fan-inner">
                    <div class="fan-label">Custom Hoodie</div>
                    <img src="<?= base_url('assets/img/hero/hoddie.jpg') ?>" alt="Hoodie"
                         style="width:7rem;height:7rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(-10deg) translateY(13px);margin-right:-18px;z-index:2">
                <div class="fan-inner">
                    <div class="fan-label">Custom Kaos</div>
                    <img src="<?= base_url('assets/img/hero/kaos.jpg') ?>" alt="Kaos"
                         style="width:8rem;height:8rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(-4deg) translateY(6px);margin-right:-16px;z-index:3">
                <div class="fan-inner">
                    <div class="fan-label">Custom Gantungan Kunci</div>
                    <img src="<?= base_url('assets/img/hero/gantungan-kunci.jpg') ?>" alt="Gantungan Kunci"
                         style="width:9rem;height:9rem;object-fit:cover;border-radius:1rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(0deg);z-index:5">
                <div class="fan-inner">
                    <div class="fan-label">Jasa Print</div>
                    <img src="<?= base_url('assets/img/hero/print.jpg') ?>" alt="Print"
                         style="width:10.5rem;height:10.5rem;object-fit:cover;border-radius:1.125rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(4deg) translateY(6px);margin-left:-16px;z-index:3">
                <div class="fan-inner">
                    <div class="fan-label">Custom Tote Bag</div>
                    <img src="<?= base_url('assets/img/hero/totebag.jpg') ?>" alt="Totebag"
                         style="width:9rem;height:9rem;object-fit:cover;border-radius:1rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(10deg) translateY(13px);margin-left:-18px;z-index:2">
                <div class="fan-inner">
                    <div class="fan-label">Custom Mug</div>
                    <img src="<?= base_url('assets/img/hero/mug.jpg') ?>" alt="Mug"
                         style="width:8rem;height:8rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(16deg) translateY(22px);margin-left:-20px;z-index:1">
                <div class="fan-inner">
                    <div class="fan-label">Custom Button Pin</div>
                    <img src="<?= base_url('assets/img/hero/button-pin.jpg') ?>" alt="Button Pin"
                         style="width:7rem;height:7rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

        </div>

        <!-- Product Fan – mobile (< sm) -->
        <div class="hero-fan-m">

            <div class="fan-card" style="transform:rotate(-12deg) translateY(12px);margin-right:-14px;z-index:2">
                <div class="fan-inner">
                    <div class="fan-label">Custom Kaos</div>
                    <img src="<?= base_url('assets/img/hero/kaos.jpg') ?>" alt="Kaos"
                         style="width:5.5rem;height:5.5rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(-5deg) translateY(5px);margin-right:-12px;z-index:3">
                <div class="fan-inner">
                    <div class="fan-label">Custom Gantungan Kunci</div>
                    <img src="<?= base_url('assets/img/hero/gantungan-kunci.jpg') ?>" alt="Gantungan Kunci"
                         style="width:6.5rem;height:6.5rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(0deg);z-index:5">
                <div class="fan-inner">
                    <div class="fan-label">Jasa Print</div>
                    <img src="<?= base_url('assets/img/hero/print.jpg') ?>" alt="Print"
                         style="width:8rem;height:8rem;object-fit:cover;border-radius:1rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(5deg) translateY(5px);margin-left:-12px;z-index:3">
                <div class="fan-inner">
                    <div class="fan-label">Custom Tote Bag</div>
                    <img src="<?= base_url('assets/img/hero/totebag.jpg') ?>" alt="Totebag"
                         style="width:6.5rem;height:6.5rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

            <div class="fan-card" style="transform:rotate(12deg) translateY(12px);margin-left:-14px;z-index:2">
                <div class="fan-inner">
                    <div class="fan-label">Custom Mug</div>
                    <img src="<?= base_url('assets/img/hero/mug.jpg') ?>" alt="Mug"
                         style="width:5.5rem;height:5.5rem;object-fit:cover;border-radius:0.875rem;display:block">
                </div>
            </div>

        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap justify-center gap-4">
            <a href="<?= base_url('/catalog') ?>"
               class="inline-flex items-center gap-2 bg-orange-600 text-white font-bold px-8 py-3.5 rounded-xl hover:bg-orange-700 transition-colors shadow-lg text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Lihat Katalog
            </a>
            <a href="<?= base_url('/customer/print') ?>"
               class="inline-flex items-center gap-2 bg-white border-2 border-gray-300 text-gray-700 font-bold px-8 py-3.5 rounded-xl hover:border-orange-400 hover:text-orange-600 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Jasa Print
            </a>
        </div>
    </div>
</section>

<!-- STATS -->
<section style="background:#ea580c">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-4">
            <?php
            $stats = [
                ['value' => count($products ?? []) . '+',    'label' => 'Produk Tersedia'],
                ['value' => count($categories ?? []) . '+',  'label' => 'Kategori'],
                ['value' => '4',                              'label' => 'Jenis Kertas Print'],
                ['value' => 'COD',                            'label' => 'Bayar di Tempat'],
            ];
            ?>
            <?php foreach ($stats as $i => $s): ?>
            <div class="py-8 px-6 text-center"
                 style="<?= $i > 0 ? 'border-left:1px solid rgba(255,255,255,0.25);' : '' ?><?= $i >= 2 ? 'border-top:1px solid rgba(255,255,255,0.25);' : '' ?>">
                <div class="text-3xl font-extrabold mb-1" style="color:#fff"><?= esc($s['value']) ?></div>
                <div class="text-xs font-medium" style="color:rgba(255,255,255,0.75)"><?= esc($s['label']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<?php if (!empty($products)): ?>
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Produk Terbaru</h2>
                <p class="text-gray-500 text-sm mt-1">Pilihan produk terkini dari Unit Produksi</p>
            </div>
            <a href="<?= base_url('/catalog') ?>"
               class="hidden sm:flex items-center gap-1 text-sm text-orange-600 hover:text-orange-800 font-semibold">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($products as $p): ?>
            <a href="<?= base_url('/product/' . esc($p['id'])) ?>"
               class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md hover:border-orange-200 transition-all duration-200">
                <div class="w-full aspect-square bg-gray-100 overflow-hidden">
                    <?php if (!empty($p['foto_utama'])): ?>
                        <img src="<?= base_url('product-image/' . esc($p['id'])) ?>"
                             alt="<?= esc($p['nama_produk']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-3">
                    <?php if (!empty($p['nama_kategori'])): ?>
                        <p class="text-xs text-orange-500 font-medium mb-1"><?= esc($p['nama_kategori']) ?></p>
                    <?php endif; ?>
                    <h3 class="text-sm font-semibold text-gray-800 leading-tight line-clamp-2"><?= esc($p['nama_produk']) ?></h3>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-orange-600 font-bold text-sm">Rp<?= esc(number_format((float)$p['harga'], 0, ',', '.')) ?></span>
                        <?php if ((int)$p['stok'] <= 0): ?>
                            <span class="text-xs text-red-500 font-medium">Habis</span>
                        <?php else: ?>
                            <span class="text-xs text-green-600 font-medium">Tersedia</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="mt-8 text-center sm:hidden">
            <a href="<?= base_url('/catalog') ?>"
               class="inline-flex items-center gap-2 text-sm text-orange-600 font-semibold">
                Lihat Semua Produk
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- LAYANAN -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-900">Layanan Kami</h2>
            <p class="text-gray-500 text-sm mt-2">Tersedia dua layanan utama untuk warga sekolah</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">

            <div class="flex gap-5 p-7 bg-orange-50 border border-orange-100 rounded-2xl hover:shadow-md transition-shadow">
                <div class="flex-shrink-0 w-14 h-14 bg-orange-600 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-gray-900 mb-2">Produk & Keperluan Sekolah</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        ATK, perlengkapan belajar, dan berbagai produk kebutuhan sekolah. Stok diperbarui langsung oleh pengurus UP.
                    </p>
                    <a href="<?= base_url('/catalog') ?>"
                       class="inline-flex items-center gap-1 text-sm text-orange-600 font-semibold hover:text-orange-800">
                        Jelajah Katalog
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="flex gap-5 p-7 bg-orange-50 border border-orange-100 rounded-2xl hover:shadow-md transition-shadow">
                <div class="flex-shrink-0 w-14 h-14 bg-orange-600 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-gray-900 mb-2">Jasa Print Dokumen</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Upload PDF, DOCX, atau XLSX. Pilih kertas &amp; warna, harga otomatis terhitung. Bayar tunai saat ambil di UP.
                    </p>
                    <a href="<?= base_url('/customer/print') ?>"
                       class="inline-flex items-center gap-1 text-sm text-orange-600 font-semibold hover:text-orange-800">
                        Pesan Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CARA BELANJA -->
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900">Cara Belanja</h2>
            <p class="text-gray-500 text-sm mt-2">Mudah dan cepat dalam 4 langkah</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <?php
            $steps = [
                ['n' => '1', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'title' => 'Daftar / Login',  'desc' => 'Buat akun dengan email atau login lewat Google.'],
                ['n' => '2', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16',                                       'title' => 'Pilih Produk',    'desc' => 'Jelajahi katalog, tambahkan ke keranjang.'],
                ['n' => '3', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title' => 'Checkout', 'desc' => 'Buat pesanan, dapatkan invoice digital.'],
                ['n' => '4', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Bayar & Ambil', 'desc' => 'Bayar tunai dan ambil produk di ruang UP.'],
            ];
            ?>
            <?php foreach ($steps as $s): ?>
            <div class="bg-white rounded-2xl p-6 text-center border border-gray-200">
                <div class="w-12 h-12 bg-orange-600 text-white rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= esc($s['icon']) ?>"/>
                    </svg>
                </div>
                <div class="text-xs font-bold text-orange-400 mb-2 uppercase tracking-wider">Langkah <?= esc($s['n']) ?></div>
                <h4 class="font-semibold text-gray-800 text-sm mb-2"><?= esc($s['title']) ?></h4>
                <p class="text-gray-400 text-xs leading-relaxed"><?= esc($s['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- KATEGORI -->
<?php if (!empty($categories)): ?>
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Telusuri Kategori</h2>
            <p class="text-gray-500 text-sm mt-2">Temukan produk sesuai kebutuhanmu</p>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="<?= base_url('/catalog') ?>"
               class="px-5 py-2 bg-orange-600 text-white text-sm font-semibold rounded-full hover:bg-orange-700 transition-colors">
                Semua Produk
            </a>
            <?php foreach ($categories as $cat): ?>
            <a href="<?= base_url('/catalog?category=' . esc($cat['id'])) ?>"
               class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-full hover:bg-orange-50 hover:text-orange-700 transition-colors border border-transparent hover:border-orange-200">
                <?= esc($cat['nama_kategori']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="bg-orange-700 py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">
            Siap Mulai Belanja?
        </h2>

        <?php if (!empty($store['jam_operasional']) || !empty($store['lokasi'])): ?>
        <div style="display:inline-flex;flex-wrap:wrap;justify-content:center;background:rgba(255,255,255,0.13);border:1px solid rgba(255,255,255,0.22);border-radius:1.25rem;margin-bottom:2rem;overflow:hidden">

            <?php if (!empty($store['jam_operasional'])): ?>
            <div style="display:flex;align-items:center;gap:0.875rem;padding:1.1rem 1.75rem">
                <div style="width:2.75rem;height:2.75rem;background:rgba(255,255,255,0.18);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="#fff" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div style="text-align:left">
                    <div style="font-size:0.625rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.55);margin-bottom:0.25rem">Jam Operasional</div>
                    <div style="font-size:1rem;font-weight:800;color:#fff;line-height:1.2"><?= esc($store['jam_operasional']) ?></div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($store['jam_operasional']) && !empty($store['lokasi'])): ?>
            <div style="width:1px;background:rgba(255,255,255,0.2);margin:0.85rem 0;flex-shrink:0"></div>
            <?php endif; ?>

            <?php if (!empty($store['lokasi'])): ?>
            <div style="display:flex;align-items:center;gap:0.875rem;padding:1.1rem 1.75rem">
                <div style="width:2.75rem;height:2.75rem;background:rgba(255,255,255,0.18);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="#fff" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div style="text-align:left">
                    <div style="font-size:0.625rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.55);margin-bottom:0.25rem">Lokasi</div>
                    <div style="font-size:1rem;font-weight:800;color:#fff;line-height:1.2"><?= esc($store['lokasi']) ?></div>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <div class="flex flex-wrap justify-center gap-3">
            <?php if (!session()->get('user_id')): ?>
            <a href="<?= base_url('/register') ?>"
               class="bg-white text-orange-700 font-bold px-8 py-3 rounded-xl hover:bg-orange-50 transition-colors shadow text-sm">
                Daftar Sekarang
            </a>
            <a href="<?= base_url('/login') ?>"
               class="bg-orange-600 border-2 border-orange-400 text-white font-bold px-8 py-3 rounded-xl hover:bg-orange-500 transition-colors text-sm">
                Masuk
            </a>
            <?php else: ?>
            <a href="<?= base_url('/catalog') ?>"
               class="bg-white text-orange-700 font-bold px-8 py-3 rounded-xl hover:bg-orange-50 transition-colors shadow text-sm">
                Mulai Belanja
            </a>
            <?php endif; ?>
            <?php if (!empty($store['no_whatsapp'])): ?>
            <a href="https://wa.me/<?= esc($store['no_whatsapp']) ?>" target="_blank" rel="noopener noreferrer"
               class="border-2 border-orange-400 text-white font-bold px-8 py-3 rounded-xl hover:bg-orange-600 transition-colors text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.116 1.522 5.849L.057 23.8a.5.5 0 00.608.634l6.077-1.592A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.6a9.6 9.6 0 01-4.898-1.34l-.35-.208-3.633.953.97-3.546-.229-.364A9.6 9.6 0 012.4 12c0-5.301 4.299-9.6 9.6-9.6s9.6 4.299 9.6 9.6-4.299 9.6-9.6 9.6z"/>
                </svg>
                WhatsApp
            </a>
            <?php endif; ?>
            <a href="<?= base_url('/info') ?>"
               class="border-2 border-orange-400 text-white font-bold px-8 py-3 rounded-xl hover:bg-orange-600 transition-colors text-sm">
                Info Toko
            </a>
        </div>
    </div>
</section>


<?php if (!empty($store['welcome_enabled']) && !empty($store['welcome_message']) && session()->get('role') !== 'admin'): ?>
<div id="wlc-bd" role="dialog" aria-modal="true" aria-label="Pesan Sambutan"
     style="position:fixed;inset:0;background:rgba(0,0,0,0.58);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);z-index:9998;display:none;align-items:center;justify-content:center;padding:1.25rem"
     onclick="if(event.target===this)fpCloseWelcome()">
    <div id="wlc-card"
         style="background:#fff;border-radius:1.375rem;max-width:27rem;width:100%;overflow:hidden;box-shadow:0 28px 72px rgba(0,0,0,0.3);position:relative">

        <div style="height:5.5rem;background:linear-gradient(135deg,#c2410c 0%,#ea580c 55%,#f97316 100%);display:flex;align-items:center;justify-content:center;position:relative">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo"
                 style="height:3.5rem;width:3.5rem;object-fit:contain;border-radius:9999px;background:#fff;padding:.45rem;box-shadow:0 2px 16px rgba(0,0,0,0.22)">
        </div>

        <div style="padding:1.875rem 2rem 2.25rem;text-align:center">
            <h2 style="font-size:1.375rem;font-weight:800;color:#111827;margin:0 0 .875rem;letter-spacing:-.02em;line-height:1.3">
                <?= esc($store['welcome_title'] ?: 'Selamat Datang!') ?>
            </h2>
            <p style="font-size:.9375rem;color:#6b7280;line-height:1.75;margin:0 0 1.875rem;white-space:pre-line">
                <?= esc($store['welcome_message']) ?>
            </p>
            <button onclick="fpCloseWelcome()" class="wlc-btn">
                Mulai Jelajahi &rarr;
            </button>
        </div>

        <button onclick="fpCloseWelcome()" aria-label="Tutup" class="wlc-x">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:.9rem;height:.9rem">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
<script>
(function(){
    if(sessionStorage.getItem('fp_welcomed'))return;
    var bd=document.getElementById('wlc-bd');
    bd.style.display='flex';
    requestAnimationFrame(function(){bd.classList.add('wlc-open');});
    document.body.style.overflow='hidden';
})();
window.fpCloseWelcome=function(){
    var bd=document.getElementById('wlc-bd');
    if(!bd)return;
    bd.style.display='none';
    bd.classList.remove('wlc-open');
    document.body.style.overflow='';
    sessionStorage.setItem('fp_welcomed','1');
};
</script>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.hero-pad { padding-top: 4.5rem; padding-bottom: 4rem; }
.hero-fan-d { display: flex; align-items: flex-end; justify-content: center; gap: 0; overflow: visible; padding-bottom: 1.5rem; margin-bottom: 2.5rem; }
.hero-fan-m { display: none; }

.fan-card {
    position: relative;
    flex-shrink: 0;
    transition: z-index 0s;
}
.fan-card:hover {
    z-index: 20 !important;
}
.fan-inner {
    position: relative;
    cursor: pointer;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                filter 0.3s ease;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,0.32));
}
.fan-inner:hover {
    transform: translateY(-18px) scale(1.07);
    filter: drop-shadow(0 24px 40px rgba(0,0,0,0.48));
}
@media (hover: none) {
    .fan-inner:hover { transform: none; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.32)); }
}
.fan-label {
    position: absolute;
    bottom: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%) translateY(6px);
    background: rgba(17,24,39,0.88);
    color: #fff;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 4px 11px;
    border-radius: 20px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    backdrop-filter: blur(4px);
}
.fan-label::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 4px solid transparent;
    border-top-color: rgba(17,24,39,0.88);
}
.fan-inner:hover .fan-label {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

@media (max-width: 639px) {
    .hero-pad { padding-top: 2.5rem; padding-bottom: 2rem; }
    .hero-fan-d { display: none; }
    .hero-fan-m { display: flex; align-items: flex-end; justify-content: center; gap: 0; overflow: visible; padding-bottom: 1rem; margin-bottom: 1.75rem; }
}
@keyframes wlc-in-bd{from{opacity:0}to{opacity:1}}
@keyframes wlc-in-card{from{opacity:0;transform:scale(.93) translateY(16px)}to{opacity:1;transform:scale(1) translateY(0)}}
#wlc-bd.wlc-open{animation:wlc-in-bd .22s ease forwards}
#wlc-bd.wlc-open #wlc-card{animation:wlc-in-card .35s cubic-bezier(.34,1.56,.64,1) forwards}
.wlc-btn{background:#ea580c;color:#fff;border:none;border-radius:.875rem;padding:.8125rem 0;font-size:.9375rem;font-weight:700;cursor:pointer;width:100%;letter-spacing:.01em;transition:background .2s}
.wlc-btn:hover{background:#c2410c}
.wlc-x{position:absolute;top:.75rem;right:.75rem;background:rgba(255,255,255,.22);border:none;border-radius:9999px;width:2rem;height:2rem;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#fff;padding:0;transition:background .15s}
.wlc-x:hover{background:rgba(255,255,255,.38)}
</style>
<?= $this->endSection() ?>

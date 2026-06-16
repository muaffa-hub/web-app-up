<?php $store = (new \App\Models\StoreInfoModel())->getInfo(); ?>
<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Fikri Production"
                         class="h-10 w-10 object-contain">
                    <h3 class="font-bold text-gray-800"><span class="text-orange-600">Fikri</span> Production</h3>
                </div>
                <p class="text-sm text-gray-500">Melayani kebutuhan produk dan jasa print untuk warga sekolah.</p>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-3">Informasi</h4>
                <ul class="space-y-1 text-sm text-gray-500">
                    <li><?= esc($store['jam_operasional'] ?? '') ?></li>
                    <li><?= esc($store['lokasi'] ?? '') ?></li>
                    <?php if (!empty($store['no_whatsapp'])): ?>
                        <li><a href="https://wa.me/<?= esc($store['no_whatsapp']) ?>" class="text-orange-600 hover:underline" target="_blank">WhatsApp: <?= esc($store['no_whatsapp']) ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-3">Tautan</h4>
                <ul class="space-y-1 text-sm">
                    <li><a href="<?= base_url('/catalog') ?>" class="text-gray-500 hover:text-orange-600">Katalog</a></li>
                    <li><a href="<?= base_url('/customer/print') ?>" class="text-gray-500 hover:text-orange-600">Jasa Print</a></li>
                    <li><a href="<?= base_url('/info') ?>" class="text-gray-500 hover:text-orange-600">Info Toko</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-100 mt-6 pt-4 text-center text-xs text-gray-400">
            &copy; <?= date('Y') ?> <span class="text-orange-500">Fikri</span> Production. All rights reserved.
        </div>
    </div>
</footer>

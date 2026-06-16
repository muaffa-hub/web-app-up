<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="text-xl font-bold text-gray-800 mb-6">Pengaturan Maintenance</h1>

<form action="<?= base_url('/admin/maintenance/update') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="space-y-4 max-w-2xl">

        <?php
        $items = [
            ['key' => 'website', 'label' => 'Website', 'desc' => 'Blokir semua halaman publik (beranda, katalog, produk, print, dsb.)',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>'],
            ['key' => 'produk', 'label' => 'Produk & Toko', 'desc' => 'Blokir katalog, detail produk, keranjang, dan checkout.',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>'],
            ['key' => 'print', 'label' => 'Layanan Print', 'desc' => 'Blokir halaman dan proses pemesanan jasa print dokumen.',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>'],
        ];
        ?>

        <?php foreach ($items as $item): ?>
        <?php $isOn = !empty($store["maintenance_{$item['key']}"]); ?>
        <div class="bg-white rounded-xl border <?= $isOn ? 'border-orange-300' : 'border-gray-200' ?> p-5 transition-colors">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg <?= $isOn ? 'bg-orange-600' : 'bg-gray-100' ?> flex items-center justify-center flex-shrink-0 transition-colors">
                        <svg class="w-5 h-5 <?= $isOn ? 'text-white' : 'text-gray-400' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?= $item['icon'] ?>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800 text-sm"><?= esc($item['label']) ?></div>
                        <div class="text-xs text-gray-500 mt-0.5"><?= esc($item['desc']) ?></div>
                    </div>
                </div>
                <label class="maint-toggle flex-shrink-0 mt-0.5" title="Toggle maintenance <?= esc($item['label']) ?>">
                    <input type="checkbox" name="maintenance_<?= esc($item['key']) ?>" value="1" <?= $isOn ? 'checked' : '' ?> onchange="this.closest('form').submit()">
                    <span class="maint-slider"></span>
                </label>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Pesan untuk pengunjung <span class="text-gray-400">(opsional)</span></label>
                <textarea name="maintenance_<?= esc($item['key']) ?>_msg" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                          placeholder="Cth: Kami sedang melakukan pembaruan sistem. Silakan kembali nanti."><?= esc($store["maintenance_{$item['key']}_msg"] ?? '') ?></textarea>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan Semua</button>
            <a href="<?= base_url('/maintenance?type=website') ?>" target="_blank" class="text-sm text-gray-500 hover:text-orange-600">Preview halaman maintenance ↗</a>
        </div>

    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.maint-toggle{position:relative;display:inline-block;width:46px;height:26px;cursor:pointer}
.maint-toggle input{opacity:0;width:0;height:0;position:absolute}
.maint-slider{position:absolute;inset:0;background:#d1d5db;border-radius:13px;transition:background .25s;cursor:pointer}
.maint-slider::before{position:absolute;content:"";height:20px;width:20px;left:3px;bottom:3px;background:#fff;border-radius:9999px;transition:transform .25s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
.maint-toggle input:checked + .maint-slider{background:#ea580c}
.maint-toggle input:checked + .maint-slider::before{transform:translateX(20px)}
</style>
<?= $this->endSection() ?>

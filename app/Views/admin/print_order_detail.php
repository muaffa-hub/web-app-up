<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= base_url('/admin/print') ?>" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Detail Pesanan Print</h1>
    </div>

    <?php $po = $order['print_order']; ?>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4 text-sm space-y-2">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-gray-400 text-xs">Invoice</p><p class="font-mono font-bold"><?= esc($order['invoice_code']) ?></p></div>
            <div><p class="text-gray-400 text-xs">Customer</p><p><?= esc($order['nama_customer']) ?></p></div>
            <div><p class="text-gray-400 text-xs">Jenis Kertas</p><p><?= esc($po['jenis_kertas']) ?></p></div>
            <div><p class="text-gray-400 text-xs">Warna</p><p><?= esc($po['warna_opsi'] === 'berwarna' ? 'Berwarna' : 'Hitam Putih') ?></p></div>
            <div><p class="text-gray-400 text-xs">Halaman (customer)</p><p><?= esc($po['jumlah_halaman']) ?></p></div>
            <div><p class="text-gray-400 text-xs">Copy</p><p><?= esc($po['total_copy']) ?></p></div>
            <div>
                <p class="text-gray-400 text-xs">Bolak-Balik</p>
                <?php if (!empty($po['bolak_balik'])): ?>
                    <span class="inline-flex items-center gap-1 text-xs bg-orange-100 text-orange-700 font-semibold px-2 py-0.5 rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Ya — harga dari ⌈<?= esc($po['jumlah_halaman']) ?> ÷ 2⌉ = <?= (int)ceil($po['jumlah_halaman'] / 2) ?> lembar
                    </span>
                <?php else: ?>
                    <p class="text-gray-600">Tidak</p>
                <?php endif; ?>
            </div>
            <div><p class="text-gray-400 text-xs">Terverifikasi</p><p class="text-blue-600 font-medium"><?= esc($po['jumlah_halaman_terverifikasi'] ?? 'Belum diverifikasi') ?></p></div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Verifikasi Jumlah Halaman</h3>
        <form action="<?= base_url('/admin/print/verify/' . esc($order['id'])) ?>" method="POST" class="flex gap-3">
            <?= csrf_field() ?>
            <input type="number" name="jumlah_halaman_terverifikasi" value="<?= esc($po['jumlah_halaman_terverifikasi'] ?? $po['jumlah_halaman']) ?>"
                   min="1" required class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-40 focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-orange-700">Simpan Verifikasi</button>
        </form>
        <p class="text-xs text-gray-400 mt-2">Menyimpan akan menghitung ulang harga dan mengirim notifikasi ke customer.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">File Dokumen</h3>
        <a href="<?= base_url('/admin/print/file/' . esc($order['id'])) ?>"
           class="inline-flex items-center gap-2 bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download File
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan</h1>
        <a href="<?= base_url('/order/' . esc($order['invoice_code'])) ?>" target="_blank"
           class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Lihat Invoice</a>
    </div>

    <?php
    $statusClass = match($order['status_pesanan']) {
        'pending'    => 'bg-yellow-100 text-yellow-700',
        'diproses'   => 'bg-blue-100 text-blue-700',
        'selesai'    => 'bg-green-100 text-green-700',
        'dibatalkan' => 'bg-red-100 text-red-700',
        default      => 'bg-gray-100 text-gray-700',
    };
    ?>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs text-gray-400">Invoice</p>
                <p class="font-mono font-bold text-gray-800"><?= esc($order['invoice_code']) ?></p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-sm font-medium <?= $statusClass ?>"><?= esc(ucfirst($order['status_pesanan'])) ?></span>
        </div>
        <div class="text-sm text-gray-500 space-y-1">
            <p>Tanggal: <?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
            <p>Tipe: <?= esc(ucfirst($order['tipe_pesanan'])) ?></p>
            <?php if ($order['catatan']): ?>
                <p>Catatan: <?= esc($order['catatan']) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($order['tipe_pesanan'] === 'produk' && !empty($order['items'])): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
            <h3 class="font-semibold text-gray-700 mb-3">Item Pesanan</h3>
            <div class="space-y-3">
                <?php foreach ($order['items'] as $item): ?>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-700"><?= esc($item['nama_produk']) ?> × <?= esc($item['qty']) ?></span>
                        <span class="font-medium">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($order['tipe_pesanan'] === 'print' && !empty($order['print_order'])): ?>
        <?php $po = $order['print_order']; ?>
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
            <h3 class="font-semibold text-gray-700 mb-3">Detail Print</h3>
            <div class="text-sm space-y-1 text-gray-600">
                <p>Jenis Kertas: <?= esc($po['jenis_kertas']) ?></p>
                <p>Warna: <?= esc($po['warna_opsi'] === 'berwarna' ? 'Berwarna' : 'Hitam Putih') ?></p>
                <p>Jumlah Halaman: <?= esc($po['jumlah_halaman']) ?></p>
                <?php if ($po['jumlah_halaman_terverifikasi']): ?>
                    <p class="text-blue-600">Halaman Terverifikasi: <?= esc($po['jumlah_halaman_terverifikasi']) ?></p>
                <?php endif; ?>
                <p>Jumlah Copy: <?= esc($po['total_copy']) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
        <div class="space-y-2 text-sm">
            <?php if ($order['diskon_kupon'] > 0): ?>
                <div class="flex justify-between text-green-600">
                    <span>Diskon Kupon (<?= esc($order['kode_kupon'] ?? '') ?>)</span>
                    <span>-Rp <?= number_format($order['diskon_kupon'], 0, ',', '.') ?></span>
                </div>
            <?php endif; ?>
            <div class="flex justify-between font-bold text-gray-800 text-base border-t border-gray-100 pt-2">
                <span>Total Bayar</span>
                <span>Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <?php if ($order['status_pesanan'] === 'pending'): ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <div class="text-sm text-yellow-700">
                <p>Segera bayar ke ruang Unit Produksi dengan membawa invoice. Pesanan akan dibatalkan otomatis setelah 24 jam jika belum dibayar.</p>
            </div>
        </div>
        <form action="<?= base_url('/customer/orders/cancel/' . esc($order['id'])) ?>" method="POST" onsubmit="return confirm('Yakin batalkan pesanan ini?')">
            <?= csrf_field() ?>
            <button type="submit" class="text-sm text-red-600 hover:underline">Batalkan Pesanan</button>
        </form>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

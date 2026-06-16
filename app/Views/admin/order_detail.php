<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= base_url('/admin/orders') ?>" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Detail Pesanan</h1>
        <a href="<?= base_url('/order/' . esc($order['invoice_code'])) ?>" target="_blank" class="ml-auto text-sm text-orange-600 hover:underline">Lihat Invoice</a>
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
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-gray-400 text-xs">Invoice</p><p class="font-mono font-bold"><?= esc($order['invoice_code']) ?></p></div>
            <div><p class="text-gray-400 text-xs">Status</p><span class="px-2 py-0.5 rounded-full text-xs <?= $statusClass ?>"><?= esc(ucfirst($order['status_pesanan'])) ?></span></div>
            <div><p class="text-gray-400 text-xs">Customer</p><p><?= esc($order['nama_customer']) ?></p></div>
            <div><p class="text-gray-400 text-xs">Email</p><p><?= esc($order['email_customer']) ?></p></div>
            <div><p class="text-gray-400 text-xs">Tipe</p><p><?= esc(ucfirst($order['tipe_pesanan'])) ?></p></div>
            <div><p class="text-gray-400 text-xs">Tanggal</p><p><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p></div>
        </div>
    </div>

    <?php if (!empty($order['items'])): ?>
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
        <h3 class="font-semibold text-gray-700 mb-3 text-sm">Item</h3>
        <div class="space-y-2">
            <?php foreach ($order['items'] as $item): ?>
                <div class="flex justify-between items-start text-sm gap-3">
                    <div class="flex items-start gap-3">
                        <?php if (!empty($item['gambar_design'])): ?>
                            <a href="<?= base_url('design-image/' . esc($item['gambar_design'])) ?>" target="_blank" title="Lihat gambar design">
                                <img src="<?= base_url('design-image/' . esc($item['gambar_design'])) ?>"
                                     alt="Design" class="w-12 h-12 object-cover rounded-lg border border-gray-200 hover:border-orange-400 transition flex-shrink-0">
                            </a>
                        <?php endif; ?>
                        <div>
                            <span class="font-medium"><?= esc($item['nama_produk']) ?></span> × <?= esc($item['qty']) ?>
                            <?php if (!empty($item['gambar_design'])): ?>
                                <p class="text-xs text-orange-600 mt-0.5">
                                    <a href="<?= base_url('design-image/' . esc($item['gambar_design'])) ?>" target="_blank" class="hover:underline">&#8595; Download gambar design</a>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="flex-shrink-0">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($order['tipe_pesanan'] === 'print' && !empty($order['print_order'])): ?>
        <?php $po = $order['print_order']; ?>
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
            <h3 class="font-semibold text-gray-700 mb-3 text-sm">Detail Print</h3>
            <div class="text-sm space-y-1 text-gray-600 mb-4">
                <p>Jenis Kertas: <?= esc($po['jenis_kertas']) ?></p>
                <p>Warna: <?= esc($po['warna_opsi'] === 'berwarna' ? 'Berwarna' : 'Hitam Putih') ?></p>
                <p>Halaman (customer): <?= esc($po['jumlah_halaman']) ?></p>
                <?php if ($po['jumlah_halaman_terverifikasi']): ?>
                    <p class="text-blue-600 font-medium">Halaman Terverifikasi: <?= esc($po['jumlah_halaman_terverifikasi']) ?></p>
                <?php endif; ?>
                <p>Copy: <?= esc($po['total_copy']) ?></p>
            </div>
            <div class="flex gap-3">
                <a href="<?= base_url('/admin/print/file/' . esc($order['id'])) ?>" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Download File</a>
                <?php if ($order['status_pesanan'] !== 'dibatalkan'): ?>
                <a href="<?= base_url('/admin/print/' . esc($order['id'])) ?>" class="border border-orange-300 text-orange-600 px-4 py-2 rounded-lg text-sm hover:bg-orange-50">Verifikasi Halaman</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
        <div class="flex justify-between font-bold text-gray-800">
            <span>Total Bayar</span>
            <span>Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?></span>
        </div>
    </div>

    <?php if ($order['status_pesanan'] !== 'dibatalkan'): ?>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-700 mb-3 text-sm">Update Status</h3>
        <form action="<?= base_url('/admin/orders/update-status/' . esc($order['id'])) ?>" method="POST" class="flex gap-3">
            <?= csrf_field() ?>
            <div class="sel-wrap flex-1">
                <select name="status_pesanan" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <?php foreach (['pending','diproses','selesai','dibatalkan'] as $s): ?>
                        <option value="<?= $s ?>" <?= $order['status_pesanan'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
            </div>
            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-orange-700">Update</button>
        </form>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

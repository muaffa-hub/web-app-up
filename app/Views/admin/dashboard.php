<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Pesanan Pending</p>
        <p class="text-3xl font-bold text-yellow-600"><?= esc($pendingOrders) ?></p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Pendapatan Hari Ini</p>
        <p class="text-2xl font-bold text-green-600">Rp <?= number_format($todayRevenue, 0, ',', '.') ?></p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Pendapatan Bulan Ini</p>
        <p class="text-2xl font-bold text-orange-600">Rp <?= number_format($monthRevenue, 0, ',', '.') ?></p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Produk Stok Rendah</p>
        <p class="text-3xl font-bold text-red-600"><?= count($lowStockItems) ?></p>
    </div>
</div>

<?php if (!empty($lowStockItems)): ?>
<div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
    <h3 class="text-sm font-semibold text-red-700 mb-2">⚠ Produk Stok Rendah (≤ 5)</h3>
    <div class="flex flex-wrap gap-2">
        <?php foreach ($lowStockItems as $p): ?>
            <a href="<?= base_url('/admin/products/edit/' . esc($p['id'])) ?>"
               class="inline-flex items-center gap-1 bg-white border border-red-200 rounded-lg px-3 py-1 text-xs text-red-700 hover:bg-red-50">
                <?= esc($p['nama_produk']) ?> <span class="font-bold">(<?= esc($p['stok']) ?>)</span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">Pesanan Terbaru</h2>
        <a href="<?= base_url('/admin/orders') ?>" class="text-sm text-orange-600 hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                    <th class="text-left px-6 py-3">Invoice</th>
                    <th class="text-left px-6 py-3">Customer</th>
                    <th class="text-left px-6 py-3">Tipe</th>
                    <th class="text-left px-6 py-3">Total</th>
                    <th class="text-left px-6 py-3">Status</th>
                    <th class="text-left px-6 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($recentOrders as $o):
                    $sc = match($o['status_pesanan']) {
                        'pending'    => 'bg-yellow-100 text-yellow-700',
                        'diproses'   => 'bg-blue-100 text-blue-700',
                        'selesai'    => 'bg-green-100 text-green-700',
                        'dibatalkan' => 'bg-red-100 text-red-700',
                        default      => 'bg-gray-100 text-gray-700',
                    };
                ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-mono text-xs"><?= esc($o['invoice_code']) ?></td>
                        <td class="px-6 py-3"><?= esc($o['nama_customer']) ?></td>
                        <td class="px-6 py-3"><?= esc(ucfirst($o['tipe_pesanan'])) ?></td>
                        <td class="px-6 py-3">Rp <?= number_format($o['total_bayar'], 0, ',', '.') ?></td>
                        <td class="px-6 py-3"><span class="px-2 py-0.5 rounded-full text-xs <?= $sc ?>"><?= esc(ucfirst($o['status_pesanan'])) ?></span></td>
                        <td class="px-6 py-3 text-gray-400"><?= date('d/m/Y', strtotime($o['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

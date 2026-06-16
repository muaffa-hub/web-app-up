<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pesanan Saya</h1>

    <?php if (empty($orders)): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
            <p class="text-gray-400">Kamu belum punya pesanan.</p>
            <a href="<?= base_url('/catalog') ?>" class="mt-4 inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700">Mulai Belanja</a>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($orders as $o): ?>
                <?php
                $statusClass = match($o['status_pesanan']) {
                    'pending'    => 'bg-yellow-100 text-yellow-700',
                    'diproses'   => 'bg-blue-100 text-blue-700',
                    'selesai'    => 'bg-green-100 text-green-700',
                    'dibatalkan' => 'bg-red-100 text-red-700',
                    default      => 'bg-gray-100 text-gray-700',
                };
                ?>
                <a href="<?= base_url('/customer/orders/' . esc($o['id'])) ?>" class="block bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono text-sm font-semibold text-gray-700"><?= esc($o['invoice_code']) ?></span>
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium <?= $statusClass ?>"><?= esc(ucfirst($o['status_pesanan'])) ?></span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span><?= esc(ucfirst($o['tipe_pesanan'])) ?> • <?= date('d M Y', strtotime($o['created_at'])) ?></span>
                        <span class="font-semibold text-gray-800">Rp <?= number_format($o['total_bayar'], 0, ',', '.') ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

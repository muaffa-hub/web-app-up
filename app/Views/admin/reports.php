<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-800">Laporan Analitik</h1>
    <div class="flex gap-3">
        <form method="GET" class="flex gap-2">
            <input type="month" name="month" value="<?= esc($selectedMonth) ?>"
                   class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
        </form>
        <a href="<?= base_url('/admin/reports/export?month=' . esc($selectedMonth)) ?>"
           class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Export CSV</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-700 mb-4 text-sm">Pendapatan Harian (<?= esc($selectedMonth) ?>)</h3>
        <?php if (empty($dailyRevenue)): ?>
            <p class="text-gray-400 text-sm">Tidak ada data.</p>
        <?php else: ?>
            <div class="space-y-2">
                <?php foreach ($dailyRevenue as $d): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600"><?= date('d M', strtotime($d['tanggal'])) ?></span>
                        <span class="font-medium">Rp <?= number_format($d['total'], 0, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-700 mb-4 text-sm">Pendapatan Bulanan (<?= date('Y', strtotime($selectedMonth)) ?>)</h3>
        <?php
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $monthlyMap = array_column($monthlyRevenue, 'total', 'bulan');
        ?>
        <div class="space-y-2">
            <?php foreach ($months as $i => $m): $total = $monthlyMap[$i+1] ?? 0; ?>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600"><?= $m ?></span>
                    <span class="font-medium <?= $total > 0 ? 'text-green-600' : 'text-gray-300' ?>">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6">
    <h3 class="font-semibold text-gray-700 mb-4 text-sm">Top 10 Produk Terlaris</h3>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                <th class="text-left py-2">#</th>
                <th class="text-left py-2">Produk</th>
                <th class="text-right py-2">Total Terjual</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($topProducts as $i => $p): ?>
                <tr>
                    <td class="py-2 text-gray-400"><?= $i + 1 ?></td>
                    <td class="py-2"><?= esc($p['nama_produk'] ?? '-') ?></td>
                    <td class="py-2 text-right font-medium"><?= esc($p['total_terjual']) ?> unit</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

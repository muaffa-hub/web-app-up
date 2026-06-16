<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-800">Manajemen Pesanan</h1>
</div>

<form action="<?= base_url('/admin/orders') ?>" method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-5 flex flex-wrap gap-3">
    <input type="text" name="q" value="<?= esc($filters['search'] ?? '') ?>" placeholder="Cari invoice / customer..."
           class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 flex-1 min-w-40">
    <div class="sel-wrap">
        <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 pr-9 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
            <option value="">Semua Status</option>
            <?php foreach (['pending','diproses','selesai','dibatalkan'] as $s): ?>
                <option value="<?= $s ?>" <?= ($filters['status'] ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
    </div>
    <div class="sel-wrap">
        <select name="tipe" class="border border-gray-300 rounded-lg px-4 py-2 pr-9 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
            <option value="">Semua Tipe</option>
            <option value="produk" <?= ($filters['tipe'] ?? '') === 'produk' ? 'selected' : '' ?>>Produk</option>
            <option value="print" <?= ($filters['tipe'] ?? '') === 'print' ? 'selected' : '' ?>>Print</option>
        </select>
        <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
    </div>
    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                <th class="text-left px-6 py-3">Invoice</th>
                <th class="text-left px-6 py-3">Customer</th>
                <th class="text-left px-6 py-3">Tipe</th>
                <th class="text-right px-6 py-3">Total</th>
                <th class="text-left px-6 py-3">Status</th>
                <th class="text-left px-6 py-3">Tanggal</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($orders as $o):
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
                    <td class="px-6 py-3 text-right">Rp <?= number_format($o['total_bayar'], 0, ',', '.') ?></td>
                    <td class="px-6 py-3"><span class="px-2 py-0.5 rounded-full text-xs <?= $sc ?>"><?= esc(ucfirst($o['status_pesanan'])) ?></span></td>
                    <td class="px-6 py-3 text-gray-400"><?= date('d/m/Y', strtotime($o['created_at'])) ?></td>
                    <td class="px-6 py-3">
                        <a href="<?= base_url('/admin/orders/' . esc($o['id'])) ?>" class="text-orange-600 hover:underline text-xs">Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

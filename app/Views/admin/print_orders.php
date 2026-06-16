<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="text-xl font-bold text-gray-800 mb-6">Pesanan Print</h1>
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                <th class="text-left px-6 py-3">Invoice</th>
                <th class="text-left px-6 py-3">Customer</th>
                <th class="text-left px-6 py-3">Kertas</th>
                <th class="text-center px-6 py-3">Hal.</th>
                <th class="text-center px-6 py-3">Terverifikasi</th>
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
                    <td class="px-6 py-3"><?= esc($o['jenis_kertas'] ?? '-') ?></td>
                    <td class="px-6 py-3 text-center"><?= esc($o['jumlah_halaman'] ?? '-') ?></td>
                    <td class="px-6 py-3 text-center">
                        <?php if ($o['jumlah_halaman_terverifikasi']): ?>
                            <span class="text-blue-600 font-medium"><?= esc($o['jumlah_halaman_terverifikasi']) ?></span>
                        <?php else: ?>
                            <span class="text-gray-300">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-3"><span class="px-2 py-0.5 rounded-full text-xs <?= $sc ?>"><?= esc(ucfirst($o['status_pesanan'])) ?></span></td>
                    <td class="px-6 py-3 text-gray-400"><?= date('d/m/Y', strtotime($o['created_at'])) ?></td>
                    <td class="px-6 py-3"><a href="<?= base_url('/admin/print/' . esc($o['id'])) ?>" class="text-orange-600 hover:underline text-xs">Detail</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

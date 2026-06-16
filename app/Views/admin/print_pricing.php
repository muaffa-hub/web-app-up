<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="text-xl font-bold text-gray-800 mb-6">Tarif Print</h1>
<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg">
    <form action="<?= base_url('/admin/print-pricing/update') ?>" method="POST">
        <?= csrf_field() ?>
        <table class="w-full text-sm mb-6">
            <thead>
                <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                    <th class="text-left py-2">Jenis Kertas</th>
                    <th class="text-left py-2">Warna</th>
                    <th class="text-right py-2">Harga/Lembar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($pricings as $p): ?>
                    <tr>
                        <td class="py-3"><?= esc($p['jenis_kertas']) ?></td>
                        <td class="py-3"><?= esc($p['warna_opsi'] === 'berwarna' ? 'Berwarna' : 'Hitam Putih') ?></td>
                        <td class="py-3 text-right">
                            <div class="price-wrap" style="display:inline-block;width:9rem">
                                <span class="price-pfx">Rp</span>
                                <input type="number" name="pricing[<?= esc($p['id']) ?>]" value="<?= esc($p['harga_per_halaman']) ?>"
                                       min="0" step="50" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 price-inp">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan Semua</button>
    </form>
</div>
<?= $this->endSection() ?>

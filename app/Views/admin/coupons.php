<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-800">Kupon Diskon</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
            class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">+ Tambah Kupon</button>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                <th class="text-left px-6 py-3">Kode</th>
                <th class="text-left px-6 py-3">Tipe</th>
                <th class="text-right px-6 py-3">Potongan</th>
                <th class="text-center px-6 py-3">Sisa Kuota</th>
                <th class="text-left px-6 py-3">Expired</th>
                <th class="text-right px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($coupons as $c): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-mono font-semibold"><?= esc($c['kode_kupon']) ?></td>
                    <td class="px-6 py-3"><?= esc($c['tipe'] === 'persen' ? 'Persen (%)' : 'Nominal (Rp)') ?></td>
                    <td class="px-6 py-3 text-right">
                        <?= $c['tipe'] === 'persen' ? esc($c['potongan']) . '%' : 'Rp ' . number_format($c['potongan'], 0, ',', '.') ?>
                    </td>
                    <td class="px-6 py-3 text-center"><?= esc($c['sisa_kuota']) ?> / <?= esc($c['kuota']) ?></td>
                    <td class="px-6 py-3 <?= strtotime($c['expired_at']) < time() ? 'text-red-500' : 'text-gray-500' ?>">
                        <?= date('d M Y', strtotime($c['expired_at'])) ?>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <a href="<?= base_url('/admin/coupons/edit/' . esc($c['id'])) ?>" class="text-orange-600 hover:underline mr-3">Edit</a>
                        <form action="<?= base_url('/admin/coupons/delete/' . esc($c['id'])) ?>" method="POST" class="inline" onsubmit="return confirm('Hapus kupon ini?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
        <h2 class="font-semibold text-gray-800 mb-4">Tambah Kupon</h2>
        <form action="<?= base_url('/admin/coupons/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Kupon</label>
                    <input type="text" name="kode_kupon" required placeholder="DISKON10"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 uppercase">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <div class="sel-wrap">
                        <select name="tipe" id="tipeAdd" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="persen">Persen (%)</option>
                            <option value="nominal">Nominal (Rp)</option>
                        </select>
                        <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Potongan</label>
                    <div class="price-wrap">
                        <span class="price-pfx" id="pfxAdd">%</span>
                        <input type="number" name="potongan" required min="1"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 price-inp">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota</label>
                    <input type="number" name="kuota" value="1" min="1" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expired</label>
                    <input type="datetime-local" name="expired_at" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan</button>
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="text-gray-500 text-sm">Batal</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.getElementById('tipeAdd').addEventListener('change', function() {
    document.getElementById('pfxAdd').textContent = this.value === 'persen' ? '%' : 'Rp';
});
</script>
<?= $this->endSection() ?>

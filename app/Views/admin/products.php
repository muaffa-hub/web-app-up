<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-800">Produk</h1>
    <a href="<?= base_url('/admin/products/create') ?>" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">+ Tambah Produk</a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                <th class="text-left px-6 py-3">Produk</th>
                <th class="text-left px-6 py-3">Kategori</th>
                <th class="text-right px-6 py-3">Harga</th>
                <th class="text-center px-6 py-3">Stok</th>
                <th class="text-center px-6 py-3">Status</th>
                <th class="text-right px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($products as $p): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-medium text-gray-800"><?= esc($p['nama_produk']) ?></td>
                    <td class="px-6 py-3 text-gray-500"><?= esc($p['nama_kategori'] ?? '-') ?></td>
                    <td class="px-6 py-3 text-right">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td class="px-6 py-3 text-center">
                        <span class="font-medium <?= $p['stok'] <= 5 ? 'text-red-600' : 'text-gray-800' ?>"><?= esc($p['stok']) ?></span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <?php if ($p['is_tampil']): ?>
                            <span style="display:inline-flex;align-items:center;gap:4px;font-size:0.7rem;font-weight:600;padding:2px 10px;border-radius:9999px;background:#dcfce7;color:#16a34a">
                                <span style="width:6px;height:6px;border-radius:9999px;background:#16a34a;display:inline-block"></span>Tampil
                            </span>
                        <?php else: ?>
                            <span style="display:inline-flex;align-items:center;gap:4px;font-size:0.7rem;font-weight:600;padding:2px 10px;border-radius:9999px;background:#f3f4f6;color:#6b7280">
                                <span style="width:6px;height:6px;border-radius:9999px;background:#9ca3af;display:inline-block"></span>Tersembunyi
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <a href="<?= base_url('/admin/products/edit/' . esc($p['id'])) ?>" class="text-orange-600 hover:underline mr-3">Edit</a>
                        <form action="<?= base_url('/admin/products/toggle/' . esc($p['id'])) ?>" method="POST" class="inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="mr-3 <?= $p['is_tampil'] ? 'text-gray-400 hover:text-gray-600' : 'text-orange-500 hover:text-orange-700' ?>">
                                <?= $p['is_tampil'] ? 'Sembunyikan' : 'Tampilkan' ?>
                            </button>
                        </form>
                        <form action="<?= base_url('/admin/products/delete/' . esc($p['id'])) ?>" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

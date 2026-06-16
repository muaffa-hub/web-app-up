<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-800">Kategori</h1>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
            class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">+ Tambah Kategori</button>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 text-xs text-gray-500 uppercase">
                <th class="text-left px-6 py-3">Nama</th>
                <th class="text-left px-6 py-3">Slug</th>
                <th class="text-left px-6 py-3">Status</th>
                <th class="text-right px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($categories as $c): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-medium"><?= esc($c['nama_kategori']) ?></td>
                    <td class="px-6 py-3 text-gray-400 font-mono text-xs"><?= esc($c['slug']) ?></td>
                    <td class="px-6 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs <?= $c['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                            <?= $c['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <a href="<?= base_url('/admin/categories/edit/' . esc($c['id'])) ?>" class="text-orange-600 hover:underline mr-3">Edit</a>
                        <form action="<?= base_url('/admin/categories/delete/' . esc($c['id'])) ?>" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
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
        <h2 class="font-semibold text-gray-800 mb-4">Tambah Kategori</h2>
        <form action="<?= base_url('/admin/categories/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <div class="sel-wrap">
                    <select name="is_active" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                    <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan</button>
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 text-sm">Batal</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

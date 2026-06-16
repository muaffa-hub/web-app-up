<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= base_url('/admin/categories') ?>" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Edit Kategori</h1>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="<?= base_url('/admin/categories/update/' . esc($category['id'])) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="<?= esc($category['nama_kategori']) ?>" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <div class="sel-wrap">
                    <select name="is_active" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="1" <?= $category['is_active'] ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= !$category['is_active'] ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                </div>
            </div>
            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

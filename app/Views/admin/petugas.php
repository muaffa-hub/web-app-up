<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">Manajemen Petugas</h1>
        <button onclick="document.getElementById('formTambah').classList.toggle('hidden')"
                class="bg-orange-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-orange-700 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Petugas
        </button>
    </div>

    <div id="formTambah" class="hidden bg-white rounded-xl border border-orange-200 p-5 mb-6">
        <h2 class="text-sm font-bold text-gray-700 mb-4">Akun Petugas Baru</h2>
        <form action="<?= base_url('/admin/petugas/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama <span class="text-red-400">*</span></label>
                    <input type="text" name="nama" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="Nama lengkap">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="email@sekolah.sch.id">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Password <span class="text-red-400">*</span></label>
                    <input type="password" name="password" required minlength="8"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                           placeholder="Min. 8 karakter">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-orange-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan</button>
                <button type="button" onclick="document.getElementById('formTambah').classList.add('hidden')"
                        class="text-gray-500 hover:text-gray-700 px-4 py-2 text-sm">Batal</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <?php if (empty($list)): ?>
        <div class="p-8 text-center text-gray-400 text-sm">Belum ada akun petugas.</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Dibuat</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($list as $p): ?>
                <tr class="hover:bg-gray-50" id="row-<?= esc($p['id']) ?>">
                    <?php $isSelf = (int) session()->get('user_id') === (int) $p['id']; ?>
                    <td class="px-5 py-3 font-medium text-gray-800"><?= esc($p['nama']) ?></td>
                    <td class="px-5 py-3 text-gray-500"><?= esc($p['email']) ?></td>
                    <td class="px-5 py-3">
                        <?php if ($isSelf): ?>
                        <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full <?= $p['role'] === 'admin' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600' ?> capitalize"><?= esc($p['role']) ?></span>
                        <?php else: ?>
                        <form action="<?= base_url('/admin/petugas/change-role/' . esc($p['id'])) ?>" method="POST" class="inline">
                            <?= csrf_field() ?>
                            <select name="role" onchange="this.form.submit()"
                                    class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 capitalize focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="petugas" <?= $p['role'] === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                <option value="admin" <?= $p['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </form>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-gray-400"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="toggleReset(<?= esc($p['id']) ?>)"
                                    class="text-xs text-gray-500 hover:text-orange-600 border border-gray-200 hover:border-orange-300 px-3 py-1.5 rounded-lg transition">
                                Reset Password
                            </button>
                            <?php if (!$isSelf && $p['role'] === 'petugas'): ?>
                            <form action="<?= base_url('/admin/petugas/delete/' . esc($p['id'])) ?>" method="POST"
                                  onsubmit="return confirm('Hapus akun <?= esc(addslashes($p['nama'])) ?>?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition">
                                    Hapus
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                        <div id="reset-<?= esc($p['id']) ?>" class="hidden mt-2">
                            <form action="<?= base_url('/admin/petugas/reset-password/' . esc($p['id'])) ?>" method="POST" class="flex gap-2">
                                <?= csrf_field() ?>
                                <input type="password" name="password" minlength="8" required
                                       class="flex-1 border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       placeholder="Password baru (min. 8 karakter)">
                                <button type="submit" class="text-xs bg-orange-600 text-white px-3 py-1.5 rounded-lg hover:bg-orange-700">Simpan</button>
                                <button type="button" onclick="toggleReset(<?= esc($p['id']) ?>)" class="text-xs text-gray-400 hover:text-gray-600">Batal</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <p class="text-xs text-gray-400 mt-4">Petugas hanya dapat melihat dan memproses pesanan. Admin memiliki akses penuh. Ubah role lewat dropdown untuk menaikkan petugas menjadi admin atau sebaliknya. Akun admin hanya dapat dihapus setelah diturunkan menjadi petugas.</p>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function toggleReset(id) {
    document.getElementById('reset-' + id).classList.toggle('hidden');
}
</script>
<?= $this->endSection() ?>

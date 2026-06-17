<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="text-xl font-bold text-gray-800 mb-6">Informasi Toko</h1>
<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg">
    <form action="<?= base_url('/admin/store-info/update') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Operasional</label>
            <input type="text" name="jam_operasional" value="<?= esc($store['jam_operasional'] ?? '') ?>" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                   placeholder="Senin-Jumat 08:00-15:00">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
            <input type="text" name="lokasi" value="<?= esc($store['lokasi'] ?? '') ?>" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                   placeholder="Ruang Unit Produksi Lantai 1">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
            <input type="text" name="no_whatsapp" value="<?= esc($store['no_whatsapp'] ?? '') ?>" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                   placeholder="628123456789">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Instagram <span class="text-gray-400 font-normal">(opsional)</span></label>
            <div class="flex">
                <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 rounded-l-lg bg-gray-50 text-gray-500 text-sm">@</span>
                <input type="text" name="instagram" value="<?= esc($store['instagram'] ?? '') ?>"
                       class="flex-1 border border-gray-300 rounded-r-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                       placeholder="fikri.production">
            </div>
        </div>
        <button type="submit" class="bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg mt-6">
    <div class="mb-5">
        <h2 class="text-base font-bold text-gray-800 mb-1">Pesan Sambutan</h2>
        <p class="text-sm text-gray-500">Popup yang muncul sekali per sesi saat pengunjung pertama kali membuka website.</p>
    </div>
    <form action="<?= base_url('/admin/store-info/update-welcome') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="flex items-center justify-between mb-5 pb-5 border-b border-gray-100">
            <div>
                <div class="text-sm font-semibold text-gray-700">Aktifkan Pesan Sambutan</div>
                <div class="text-xs text-gray-400 mt-0.5">Muncul sekali per sesi browser pengunjung</div>
            </div>
            <label class="maint-toggle flex-shrink-0">
                <input type="checkbox" name="welcome_enabled" value="1" <?= !empty($store['welcome_enabled']) ? 'checked' : '' ?>>
                <span class="maint-slider"></span>
            </label>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-gray-400 font-normal">(opsional, default: Selamat Datang!)</span></label>
            <input type="text" name="welcome_title" value="<?= esc($store['welcome_title'] ?? '') ?>"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                   placeholder="Selamat Datang!">
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pesan <span class="text-red-400">*</span></label>
            <textarea name="welcome_message" rows="4" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                      placeholder="Cth: Halo! Selamat datang di Unit Produksi Fikri Production. Temukan berbagai produk dan layanan print terbaik untuk kebutuhan sekolahmu."><?= esc($store['welcome_message'] ?? '') ?></textarea>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan Pesan</button>
            <?php if (!empty($store['welcome_enabled'])): ?>
            <span class="text-xs text-green-600 font-medium flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Aktif
            </span>
            <?php else: ?>
            <span class="text-xs text-gray-400">Nonaktif</span>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg mt-6">
    <div class="mb-5">
        <h2 class="text-base font-bold text-gray-800 mb-1">Backup Dokumen ke Google Drive</h2>
        <p class="text-sm text-gray-500">Dokumen print dari pesanan selesai &gt; 3 hari otomatis dibackup ke Google Drive lalu dihapus dari server. Tombol unduh akan diarahkan ke Drive.</p>
    </div>

    <?php if (!$driveConfigured): ?>
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-700">
        Kredensial Google Drive belum diatur. Tambahkan <code class="bg-yellow-100 px-1 rounded">googledrive.clientId</code>, <code class="bg-yellow-100 px-1 rounded">googledrive.clientSecret</code>, dan <code class="bg-yellow-100 px-1 rounded">googledrive.folderId</code> di file <code class="bg-yellow-100 px-1 rounded">.env</code>, lalu muat ulang halaman ini.
    </div>
    <?php elseif ($driveConnected): ?>
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-2 text-sm">
            <span class="inline-flex items-center gap-1.5 text-green-600 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Terhubung
            </span>
            <?php if ($driveEmail): ?><span class="text-gray-500"><?= esc($driveEmail) ?></span><?php endif; ?>
        </div>
        <form action="<?= base_url('/admin/drive/disconnect') ?>" method="POST" onsubmit="return confirm('Putuskan koneksi Google Drive?')">
            <?= csrf_field() ?>
            <button type="submit" class="text-xs text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition">Putuskan</button>
        </form>
    </div>
    <?php else: ?>
    <a href="<?= base_url('/admin/drive/connect') ?>"
       class="inline-flex items-center gap-2 bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        Hubungkan Google Drive
    </a>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.maint-toggle{position:relative;display:inline-block;width:46px;height:26px;cursor:pointer}
.maint-toggle input{opacity:0;width:0;height:0;position:absolute}
.maint-slider{position:absolute;inset:0;background:#d1d5db;border-radius:13px;transition:background .25s;cursor:pointer}
.maint-slider::before{position:absolute;content:"";height:20px;width:20px;left:3px;bottom:3px;background:#fff;border-radius:9999px;transition:transform .25s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
.maint-toggle input:checked + .maint-slider{background:#ea580c}
.maint-toggle input:checked + .maint-slider::before{transform:translateX(20px)}
</style>
<?= $this->endSection() ?>

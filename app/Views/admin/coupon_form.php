<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= base_url('/admin/coupons') ?>" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Edit Kupon</h1>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="<?= base_url('/admin/coupons/update/' . esc($coupon['id'])) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Kupon</label>
                <input type="text" value="<?= esc($coupon['kode_kupon']) ?>" disabled
                       class="w-full border border-gray-200 bg-gray-50 rounded-lg px-4 py-2.5 text-sm text-gray-400">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <div class="sel-wrap">
                        <select name="tipe" id="tipeEdit" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="persen" <?= $coupon['tipe'] === 'persen' ? 'selected' : '' ?>>Persen (%)</option>
                            <option value="nominal" <?= $coupon['tipe'] === 'nominal' ? 'selected' : '' ?>>Nominal (Rp)</option>
                        </select>
                        <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Potongan</label>
                    <div class="price-wrap">
                        <span class="price-pfx" id="pfxEdit"><?= $coupon['tipe'] === 'persen' ? '%' : 'Rp' ?></span>
                        <input type="number" name="potongan" value="<?= esc($coupon['potongan']) ?>" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 price-inp">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota</label>
                    <input type="number" name="kuota" value="<?= esc($coupon['kuota']) ?>" required min="1"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expired</label>
                    <input type="datetime-local" name="expired_at" value="<?= date('Y-m-d\TH:i', strtotime($coupon['expired_at'])) ?>" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>
            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">Simpan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.getElementById('tipeEdit').addEventListener('change', function() {
    document.getElementById('pfxEdit').textContent = this.value === 'persen' ? '%' : 'Rp';
});
</script>
<?= $this->endSection() ?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-yellow-300 p-6">
        <div class="flex items-center gap-3 mb-4">
            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <h2 class="text-lg font-semibold text-gray-800">Kamu sudah punya pesanan serupa yang masih pending.</h2>
        </div>
        <p class="text-gray-600 text-sm mb-6">Apakah kamu tetap ingin membuat pesanan baru?</p>

        <form action="<?= base_url('/customer/checkout/process') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="confirm_duplicate" value="1">
            <?php if ($coupon): ?>
                <input type="hidden" name="coupon_code" value="<?= esc($coupon['kode_kupon']) ?>">
            <?php endif; ?>
            <?php if ($catatan): ?>
                <input type="hidden" name="catatan" value="<?= esc($catatan) ?>">
            <?php endif; ?>
            <div class="flex gap-3">
                <button type="submit" class="bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-700">Ya, Buat Pesanan Baru</button>
                <a href="<?= base_url('/customer/orders') ?>" class="text-gray-500 hover:text-gray-700 px-4 py-2.5 text-sm">Lihat Pesanan Lama</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

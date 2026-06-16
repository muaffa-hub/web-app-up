<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Wishlist Saya</h1>

    <?php if (empty($items)): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
            <p class="text-gray-400 mb-4">Wishlist kamu kosong.</p>
            <a href="<?= base_url('/catalog') ?>" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700">Jelajahi Produk</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($items as $item): ?>
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <a href="<?= base_url('/product/' . esc($item['product_id'])) ?>">
                        <div class="aspect-square bg-gray-100">
                            <?php if ($item['foto_utama']): ?>
                                <img src="<?= base_url('product-image/' . esc($item['product_id'])) ?>" alt="" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                        <div class="p-3">
                            <p class="text-sm font-medium text-gray-800 truncate"><?= esc($item['nama_produk']) ?></p>
                            <p class="text-orange-600 font-semibold text-sm">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                        </div>
                    </a>
                    <div class="px-3 pb-3">
                        <button onclick="removeWishlist(<?= esc($item['product_id']) ?>, this)" class="text-xs text-red-500 hover:underline">Hapus dari Wishlist</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
function removeWishlist(productId, btn) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    fetch('<?= base_url('/customer/wishlist/toggle') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `product_id=${productId}&<?= csrf_token() ?>=${csrfToken}`
    }).then(r => r.json()).then(() => btn.closest('.bg-white').remove());
}
</script>
<?= $this->endSection() ?>

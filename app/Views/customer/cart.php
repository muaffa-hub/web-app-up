<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Belanja</h1>

    <?php if (empty($items)): ?>
        <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-10H5.4m0 0L7 13m0 0l-2 9m2-9h10m0 0l2 9"/></svg>
            <p class="text-gray-400 mb-4">Keranjang kamu kosong</p>
            <a href="<?= base_url('/catalog') ?>" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700">Mulai Belanja</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-3" id="cartItems">
                <?php foreach ($items as $item): ?>
                    <div class="bg-white rounded-xl border border-gray-200 p-4 flex gap-4 items-center" id="cart-item-<?= esc($item['id']) ?>">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            <?php if ($item['foto_utama']): ?>
                                <img src="<?= base_url('product-image/' . esc($item['product_id'])) ?>" alt="" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 truncate"><?= esc($item['nama_produk']) ?></p>
                            <p class="text-orange-600 text-sm font-semibold">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                            <?php if (!empty($item['gambar_design'])): ?>
                            <div class="flex items-center gap-1.5 mt-1">
                                <img src="<?= base_url('design-image/' . esc($item['gambar_design'])) ?>"
                                     alt="Design" class="w-8 h-8 object-cover rounded border border-orange-200">
                                <span class="text-xs text-orange-600 font-medium">Gambar design terlampir</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="updateQty(<?= esc($item['id']) ?>, <?= esc($item['qty'] - 1) ?>)" class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">-</button>
                            <span class="w-8 text-center text-sm font-medium" id="qty-<?= esc($item['id']) ?>"><?= esc($item['qty']) ?></span>
                            <button onclick="updateQty(<?= esc($item['id']) ?>, <?= esc($item['qty'] + 1) ?>)" class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">+</button>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-sm text-gray-800">Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></p>
                            <button onclick="removeItem(<?= esc($item['id']) ?>)" class="text-xs text-red-500 hover:underline mt-1">Hapus</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 h-fit sticky top-20">
                <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                <?php
                    $subtotal = array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $items));
                ?>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                </div>
                <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between font-semibold text-gray-800">
                    <span>Total</span>
                    <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                </div>
                <?php if (session()->get('user_id')): ?>
                    <a href="<?= base_url('/customer/checkout') ?>" class="block w-full mt-4 bg-orange-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-orange-700 transition">Checkout</a>
                <?php else: ?>
                    <a href="<?= base_url('/login') ?>" class="block w-full mt-4 bg-orange-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-orange-700 transition">Login untuk Checkout</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
function updateQty(cartId, qty) {
    if (qty < 1) { removeItem(cartId); return; }
    fetch('<?= base_url('/customer/cart/update') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cart_id=${cartId}&qty=${qty}&<?= csrf_token() ?>=${csrfToken}`
    }).then(r => r.json()).then(d => {
        if (d.success) { document.getElementById('qty-'+cartId).textContent = d.qty; }
    });
}
function removeItem(cartId) {
    if (!confirm('Hapus item ini?')) return;
    fetch('<?= base_url('/customer/cart/remove') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cart_id=${cartId}&<?= csrf_token() ?>=${csrfToken}`
    }).then(r => r.json()).then(d => {
        if (d.success) {
            document.getElementById('cart-item-'+cartId)?.remove();
        }
    });
}
</script>
<?= $this->endSection() ?>

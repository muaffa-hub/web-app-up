<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h1>

    <form action="<?= base_url('/customer/checkout/process') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-4">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-700 mb-4">Item Pesanan</h3>
                    <div class="space-y-3">
                        <?php $subtotal = 0; foreach ($items as $item): $subtotal += $item['harga'] * $item['qty']; ?>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-700"><?= esc($item['nama_produk']) ?> × <?= esc($item['qty']) ?></span>
                                <span class="font-medium">Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Kode Kupon (opsional)</h3>
                    <div class="flex gap-2">
                        <input type="text" name="coupon_code" id="couponInput" placeholder="Masukkan kode kupon"
                               class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button type="button" onclick="applyCoupon()" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Terapkan</button>
                    </div>
                    <div id="couponMsg" class="mt-2 text-sm"></div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Catatan (opsional)</h3>
                    <textarea name="catatan" rows="3" placeholder="Tambahkan catatan untuk pesanan kamu..."
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 h-fit sticky top-20">
                <h3 class="font-semibold text-gray-800 mb-4">Ringkasan</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-green-600" id="discountRow" style="display:none!important">
                        <span>Diskon Kupon</span>
                        <span id="discountAmt">-Rp 0</span>
                    </div>
                </div>
                <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between font-bold text-gray-800">
                    <span>Total</span>
                    <span id="totalAmt">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                </div>
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3 text-xs text-blue-700">
                    <strong>Metode Pembayaran:</strong> Cash on Desk<br>
                    Bayar langsung ke ruang Unit Produksi dengan membawa invoice.
                </div>
                <button type="submit" class="w-full mt-4 bg-orange-600 text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition">Buat Pesanan</button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
const subtotal = <?= $subtotal ?>;
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
function formatRp(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
}
function applyCoupon() {
    const code = document.getElementById('couponInput').value;
    if (!code) return;
    fetch('<?= base_url('/customer/checkout/apply-coupon') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `coupon_code=${encodeURIComponent(code)}&subtotal=${subtotal}&<?= csrf_token() ?>=${csrfToken}`
    }).then(r => r.json()).then(d => {
        const msg = document.getElementById('couponMsg');
        if (d.valid) {
            msg.className = 'mt-2 text-sm text-green-600';
            msg.textContent = `Kupon berhasil! Diskon: ${formatRp(d.diskon)}`;
            const discRow = document.getElementById('discountRow');
            discRow.style.removeProperty('display');
            document.getElementById('discountAmt').textContent = '-' + formatRp(d.diskon);
            document.getElementById('totalAmt').textContent = formatRp(subtotal - d.diskon);
        } else {
            msg.className = 'mt-2 text-sm text-red-500';
            msg.textContent = d.message;
        }
    });
}
</script>
<?= $this->endSection() ?>

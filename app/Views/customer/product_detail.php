<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-5xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-xl border border-gray-200 p-6">
        <div>
            <?php if (!empty($product['images'])): ?>
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-3">
                    <img id="mainImage" src="<?= base_url('product-image/' . esc($product['id']) . '/0') ?>" alt="<?= esc($product['nama_produk']) ?>" class="w-full h-full object-cover">
                </div>
                <?php if (count($product['images']) > 1): ?>
                    <div class="flex gap-2 overflow-x-auto">
                        <?php foreach ($product['images'] as $idx => $img): ?>
                            <button onclick="document.getElementById('mainImage').src='<?= base_url('product-image/' . esc($product['id']) . '/' . $idx) ?>'"
                                    class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden border-2 border-transparent hover:border-orange-400">
                                <img src="<?= base_url('product-image/' . esc($product['id']) . '/' . $idx) ?>" alt="" class="w-full h-full object-cover">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex flex-col">
            <div class="mb-1">
                <span class="text-xs text-gray-400 uppercase tracking-wide"><?= esc($product['nama_kategori'] ?? '') ?></span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= esc($product['nama_produk']) ?></h1>

            <div class="flex items-center gap-2 mb-4">
                <div class="flex">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-4 h-4 <?= $i <= round($product['avg_rating']) ? 'text-yellow-400' : 'text-gray-200' ?> fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <?php endfor; ?>
                </div>
                <span class="text-sm text-gray-500"><?= number_format($product['avg_rating'], 1) ?> (<?= esc($product['review_count']) ?> ulasan)</span>
            </div>

            <div class="text-3xl font-bold text-orange-600 mb-4">Rp <?= number_format($product['harga'], 0, ',', '.') ?></div>

            <?php if (!empty($product['deskripsi'])): ?>
            <div class="prose prose-sm text-gray-600 mb-4 leading-relaxed" style="max-width:none">
                <?= $product['deskripsi'] ?>
            </div>
            <?php endif; ?>

            <div class="mb-4">
                <?php if ($product['stok'] <= 0): ?>
                    <span class="text-red-500 font-medium text-sm">Stok habis</span>
                <?php else: ?>
                    <span class="text-green-600 text-sm">Stok tersedia: <strong><?= esc($product['stok']) ?></strong></span>
                <?php endif; ?>
            </div>

            <?php if ($product['stok'] > 0): ?>
                <form action="<?= base_url('/customer/cart/add') ?>" method="POST" enctype="multipart/form-data" id="addToCart">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
                    <div class="flex items-center gap-3 mb-4">
                        <label class="text-sm text-gray-700">Qty:</label>
                        <input type="number" name="qty" value="1" min="1" max="<?= esc($product['stok']) ?>"
                               class="w-20 border border-gray-300 rounded-lg px-3 py-2 text-center text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <?php if (!empty($product['is_custom'])): ?>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Design</label>
                        <input type="file" name="gambar_design" id="designInput" accept="image/jpeg,image/png,image/webp" class="sr-only">

                        <div id="designDropZone"
                             class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer transition-all hover:border-orange-400 hover:bg-orange-50 group">
                            <div id="designIdle">
                                <div class="w-12 h-12 bg-orange-50 group-hover:bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-colors">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 mb-1">Seret gambar design ke sini atau <span class="text-orange-600 underline">klik untuk pilih</span></p>
                                <p class="text-xs text-gray-400">JPG, PNG, WEBP &bull; Maksimal 5MB</p>
                            </div>
                            <div id="designDragging" class="hidden absolute inset-0 rounded-xl bg-orange-50 border-2 border-orange-400 flex flex-col items-center justify-center gap-2">
                                <svg class="w-9 h-9 text-orange-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                                <p class="text-sm font-semibold text-orange-600">Lepaskan untuk upload</p>
                            </div>
                        </div>

                        <div id="designPreview" class="hidden mt-3">
                            <div id="designCard" class="flex items-center gap-4 p-4 rounded-xl border-2 border-orange-200 bg-orange-50 transition-all">
                                <img id="designThumb" src="" alt="Preview" class="w-14 h-14 object-cover rounded-xl border border-orange-200 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p id="designFileName" class="text-sm font-semibold text-gray-800 truncate"></p>
                                    <p id="designFileSize" class="text-xs text-gray-500 mt-0.5"></p>
                                    <p id="designError" class="text-xs text-red-500 mt-1 hidden font-medium"></p>
                                </div>
                                <button type="button" id="designClear"
                                        class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="flex gap-3">
                        <button type="submit" id="submitCartBtn" class="flex-1 bg-orange-600 text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Tambah ke Keranjang
                        </button>
                        <?php if (session()->get('user_id')): ?>
                            <button type="button" onclick="toggleWishlist(<?= esc($product['id']) ?>)"
                                    id="wishlistBtn"
                                    class="p-3 rounded-lg border <?= $isWishlisted ? 'border-red-300 bg-red-50 text-red-500' : 'border-gray-300 text-gray-400 hover:text-red-500' ?> transition">
                                <svg class="w-6 h-6 <?= $isWishlisted ? 'fill-current' : '' ?>" viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            <?php else: ?>
                <button disabled class="w-full bg-gray-200 text-gray-500 py-3 rounded-lg font-semibold cursor-not-allowed">Stok Habis</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ulasan Produk</h2>
        <?php if (session()->get('user_id') && $hasBought && !$hasReviewed): ?>
            <form action="<?= base_url('/customer/orders/review/' . esc($product['id'])) ?>" method="POST" class="mb-6 bg-gray-50 rounded-lg p-4">
                <?= csrf_field() ?>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating kamu:</label>
                <div class="flex gap-1 mb-3" id="ratingStars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <button type="button" onclick="setRating(<?= $i ?>)" class="text-3xl text-gray-300 hover:text-yellow-400 star-btn" data-val="<?= $i ?>">★</button>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="0">
                <textarea name="ulasan" placeholder="Tulis ulasan kamu..." rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 mb-3"></textarea>
                <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-orange-700">Kirim Ulasan</button>
            </form>
        <?php endif; ?>

        <?php if (empty($reviews)): ?>
            <p class="text-gray-400 text-sm">Belum ada ulasan untuk produk ini.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($reviews as $r): ?>
                    <div class="border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-medium text-sm text-gray-800"><?= esc($r['nama_user']) ?></span>
                            <div class="flex">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <svg class="w-3 h-3 <?= $i <= $r['rating'] ? 'text-yellow-400' : 'text-gray-200' ?> fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php if ($r['ulasan']): ?>
                            <p class="text-sm text-gray-600"><?= esc($r['ulasan']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
function setRating(val) {
    document.getElementById('ratingInput').value = val;
    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.classList.toggle('text-yellow-400', parseInt(btn.dataset.val) <= val);
        btn.classList.toggle('text-gray-300', parseInt(btn.dataset.val) > val);
    });
}
function toggleWishlist(productId) {
    fetch('<?= base_url('/customer/wishlist/toggle') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
        body: 'product_id=' + productId
    }).then(r => r.json()).then(data => {
        const btn = document.getElementById('wishlistBtn');
        if (data.wishlisted) {
            btn.classList.add('border-red-300', 'bg-red-50', 'text-red-500');
            btn.querySelector('svg').classList.add('fill-current');
        } else {
            btn.classList.remove('border-red-300', 'bg-red-50', 'text-red-500');
            btn.querySelector('svg').classList.remove('fill-current');
        }
    });
}
document.getElementById('addToCart')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    }).then(r => r.json()).then(data => {
        if (data.success) {
            alert(data.message);
        } else {
            alert(data.message);
        }
    });
});

(function () {
    const elInput    = document.getElementById('designInput');
    const elDropZone = document.getElementById('designDropZone');
    const elDragging = document.getElementById('designDragging');
    const elPreview  = document.getElementById('designPreview');
    const elThumb    = document.getElementById('designThumb');
    const elName     = document.getElementById('designFileName');
    const elSize     = document.getElementById('designFileSize');
    const elError    = document.getElementById('designError');
    const elClear    = document.getElementById('designClear');
    const elSubmit   = document.getElementById('submitCartBtn');

    if (!elInput) return;

    const MAX_B        = 5 * 1024 * 1024;
    const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/webp'];

    function showDesign(file) {
        const badType = !ALLOWED_MIME.includes(file.type);
        const tooBig  = file.size > MAX_B;
        const hasErr  = badType || tooBig;

        const reader = new FileReader();
        reader.onload = e => {
            elThumb.src = e.target.result;
            elDropZone.classList.add('hidden');
            elPreview.classList.remove('hidden');
            elName.textContent = file.name;
            elSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            elError.classList.add('hidden');
            if (badType) { elError.textContent = '⚠ Format tidak didukung. Gunakan JPG, PNG, atau WEBP.'; elError.classList.remove('hidden'); }
            else if (tooBig) { elError.textContent = '⚠ Ukuran melebihi 5MB — pilih file lain.'; elError.classList.remove('hidden'); }
            if (elSubmit) elSubmit.disabled = hasErr;
        };
        reader.readAsDataURL(file);
    }

    function handleDesignFile(file) {
        if (!file) return;
        const dt = new DataTransfer();
        dt.items.add(file);
        elInput.files = dt.files;
        showDesign(file);
    }

    function clearDesign() {
        elInput.value = '';
        elPreview.classList.add('hidden');
        elDropZone.classList.remove('hidden');
        elThumb.src = '';
        if (elSubmit) elSubmit.disabled = false;
    }

    elDropZone.addEventListener('click', () => elInput.click());
    elInput.addEventListener('change', function () { if (this.files[0]) handleDesignFile(this.files[0]); });
    elDropZone.addEventListener('dragenter', e => { e.preventDefault(); elDragging.classList.remove('hidden'); });
    elDropZone.addEventListener('dragleave', e => { if (!elDropZone.contains(e.relatedTarget)) elDragging.classList.add('hidden'); });
    elDropZone.addEventListener('dragover', e => e.preventDefault());
    elDropZone.addEventListener('drop', e => { e.preventDefault(); elDragging.classList.add('hidden'); handleDesignFile(e.dataTransfer.files[0]); });
    elClear.addEventListener('click', clearDesign);
}());
</script>
<?= $this->endSection() ?>

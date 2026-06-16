<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto">
    <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-orange-600 mb-4 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Beranda
    </a>
    <div class="flex flex-col md:flex-row gap-6">
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-700 mb-4">Filter</h3>
                <form action="<?= base_url('/catalog') ?>" method="GET" id="filterForm">
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-500 mb-2 uppercase tracking-wide">Kategori</label>
                        <div class="space-y-1">
                            <a href="<?= base_url('/catalog') ?>" class="block text-sm <?= empty($filters['category']) ? 'text-orange-600 font-medium' : 'text-gray-600 hover:text-orange-600' ?>">Semua Kategori</a>
                            <?php foreach ($categories as $cat): ?>
                                <a href="<?= base_url('/catalog?category=' . esc($cat['id']) . (!empty($filters['q']) ? '&q=' . urlencode($filters['q']) : '')) ?>"
                                   class="block text-sm <?= $filters['category'] == $cat['id'] ? 'text-orange-600 font-medium' : 'text-gray-600 hover:text-orange-600' ?>">
                                    <?= esc($cat['nama_kategori']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-2 uppercase tracking-wide">Urutkan</label>
                        <div class="sel-wrap">
                            <select name="sort" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="" <?= empty($filters['sort']) ? 'selected' : '' ?>>Terbaru</option>
                                <option value="harga_asc" <?= $filters['sort'] === 'harga_asc' ? 'selected' : '' ?>>Harga Terendah</option>
                                <option value="harga_desc" <?= $filters['sort'] === 'harga_desc' ? 'selected' : '' ?>>Harga Tertinggi</option>
                                <option value="rating" <?= $filters['sort'] === 'rating' ? 'selected' : '' ?>>Rating Tertinggi</option>
                            </select>
                            <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                        </div>
                        <?php if (!empty($filters['category'])): ?>
                            <input type="hidden" name="category" value="<?= esc($filters['category']) ?>">
                        <?php endif; ?>
                        <?php if (!empty($filters['q'])): ?>
                            <input type="hidden" name="q" value="<?= esc($filters['q']) ?>">
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <?php if (!empty($filters['q'])): ?>
                <p class="text-gray-500 text-sm mb-4">Hasil pencarian untuk: <strong>"<?= esc($filters['q']) ?>"</strong> (<?= count($products) ?> produk)</p>
            <?php endif; ?>

            <?php if (empty($products)): ?>
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    <p class="text-gray-400">Belum ada produk.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($products as $p): ?>
                        <a href="<?= base_url('/product/' . $p['id']) ?>" class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition overflow-hidden group">
                            <div class="aspect-square bg-gray-100 overflow-hidden">
                                <?php if ($p['foto_utama']): ?>
                                    <img src="<?= base_url('product-image/' . esc($p['id'])) ?>" alt="<?= esc($p['nama_produk']) ?>"
                                         class="w-full h-full object-cover group-hover:scale-105 transition">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-medium text-gray-800 truncate"><?= esc($p['nama_produk']) ?></h3>
                                <p class="text-orange-600 font-semibold text-sm mt-1">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                <div class="flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-xs text-gray-500"><?= number_format($p['avg_rating'], 1) ?> (<?= esc($p['review_count']) ?>)</span>
                                </div>
                                <?php if ($p['stok'] <= 0): ?>
                                    <span class="inline-block mt-2 text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Habis</span>
                                <?php elseif ($p['stok'] <= 5): ?>
                                    <span class="inline-block mt-2 text-xs bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full">Sisa <?= esc($p['stok']) ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

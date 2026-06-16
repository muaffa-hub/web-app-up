<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= base_url('/admin/products') ?>" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800"><?= $product ? 'Edit Produk' : 'Tambah Produk' ?></h1>
    </div>

    <form action="<?= $product ? base_url('/admin/products/update/' . esc($product['id'])) : base_url('/admin/products/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" value="<?= esc($product['nama_produk'] ?? '') ?>" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <div class="sel-wrap">
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= esc($c['id']) ?>" <?= ($product['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                    <?= esc($c['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga <span class="text-red-500">*</span></label>
                    <div class="price-wrap">
                        <span class="price-pfx">Rp</span>
                        <input type="number" name="harga" value="<?= esc($product['harga'] ?? '') ?>" required min="0" step="100"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 price-inp">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="<?= esc($product['stok'] ?? 0) ?>" required min="0"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="md:col-span-2">
                    <label class="pf-toggle-wrap">
                        <input type="checkbox" name="is_custom" value="1" <?= !empty($product['is_custom']) ? 'checked' : '' ?>>
                        <span class="pf-slider"></span>
                        <span class="pf-toggle-label">
                            <span class="text-sm font-medium text-gray-700">Produk Custom</span>
                            <span class="text-xs text-gray-400 font-normal ml-1">— pelanggan bisa upload gambar desain</span>
                        </span>
                    </label>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <div id="quillWrap">
                        <div id="quillEditor"></div>
                    </div>
                    <input type="hidden" name="deskripsi" id="deskripsiInput">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
            <?php if ($product && !empty($product['images'])): ?>
                <div class="flex flex-wrap gap-3 mb-4">
                    <?php foreach ($product['images'] as $img): ?>
                        <div class="relative">
                            <img src="<?= base_url('product-image/img/' . esc($img['id'])) ?>" class="w-20 h-20 object-cover rounded-lg border">
                            <button type="button" onclick="deleteImage(<?= esc($img['id']) ?>, this)"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">×</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <input type="file" name="foto_produk[]" multiple accept="image/*"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm">
            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks. 5MB per foto.</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-700">
                <?= $product ? 'Simpan Perubahan' : 'Tambah Produk' ?>
            </button>
            <a href="<?= base_url('/admin/products') ?>" class="text-gray-500 hover:text-gray-700 px-4 py-2.5 text-sm">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<style>
#quillWrap { border:1px solid #d1d5db; border-radius:0.5rem; overflow:hidden; transition:box-shadow .15s,border-color .15s; }
#quillWrap:focus-within { border-color:#f97316; box-shadow:0 0 0 2px rgba(249,115,22,.25); }
.ql-toolbar.ql-snow { border:none !important; border-bottom:1px solid #d1d5db !important; background:#f9fafb; }
.ql-container.ql-snow { border:none !important; }
.ql-editor { min-height:160px; font-size:.875rem; }
.pf-toggle-wrap{display:inline-flex;align-items:center;gap:.75rem;cursor:pointer;user-select:none}
.pf-toggle-wrap input{position:absolute;opacity:0;width:0;height:0}
.pf-slider{position:relative;display:inline-block;width:44px;height:24px;background:#d1d5db;border-radius:12px;flex-shrink:0;transition:background .22s}
.pf-slider::before{content:"";position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:9999px;transition:transform .22s;box-shadow:0 1px 3px rgba(0,0,0,.18)}
.pf-toggle-wrap input:checked + .pf-slider{background:#ea580c}
.pf-toggle-wrap input:checked + .pf-slider::before{transform:translateX(20px)}
</style>
<script>
const uploadImageUrl = '<?= base_url('/admin/products/upload-image') ?>';
const csrfName2      = '<?= csrf_token() ?>';

const quill = new Quill('#quillEditor', {
    theme: 'snow',
    placeholder: 'Tulis deskripsi produk...',
    modules: {
        toolbar: {
            container: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'image'],
                ['clean'],
            ],
            handlers: {
                image: function () {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/jpeg,image/png,image/webp,image/gif');
                    input.click();
                    input.addEventListener('change', function () {
                        const file = this.files[0];
                        if (!file) return;
                        const fd = new FormData();
                        fd.append('image', file);
                        fd.append(csrfName2, document.querySelector('meta[name="csrf-token"]').content);
                        fetch(uploadImageUrl, { method: 'POST', body: fd })
                            .then(r => r.json())
                            .then(d => {
                                if (d.url) {
                                    const range = quill.getSelection(true);
                                    quill.insertEmbed(range.index, 'image', d.url);
                                    quill.setSelection(range.index + 1);
                                }
                            });
                    });
                },
            },
        },
    },
});

const existingHtml = <?= json_encode($product['deskripsi'] ?? '') ?>;
if (existingHtml) quill.clipboard.dangerouslyPasteHTML(existingHtml);

document.querySelector('form').addEventListener('submit', function () {
    document.getElementById('deskripsiInput').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
});

const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
function deleteImage(id, btn) {
    if (!confirm('Hapus foto ini?')) return;
    fetch('<?= base_url('/admin/products/delete-image/') ?>' + id, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: '<?= csrf_token() ?>=' + csrfToken
    }).then(r => r.json()).then(d => {
        if (d.success) btn.closest('.relative').remove();
    });
}
</script>
<?= $this->endSection() ?>

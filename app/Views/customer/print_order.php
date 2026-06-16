<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-orange-600 mb-4 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Beranda
    </a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Jasa Print Dokumen</h1>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="<?= base_url('/customer/print/process') ?>" method="POST" enctype="multipart/form-data" id="printForm">
            <?= csrf_field() ?>

            <!-- Upload File -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Dokumen <span class="text-red-500">*</span>
                </label>

                <input type="file" name="dokumen" id="dokumenInput" accept=".pdf,.docx,.xlsx" required class="sr-only">

                <!-- Drop Zone -->
                <div id="dropZone"
                     class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer transition-all duration-200 hover:border-orange-400 hover:bg-orange-50 group">
                    <div id="dropZoneIdle">
                        <div class="w-14 h-14 bg-orange-50 group-hover:bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-colors">
                            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-1">Seret file ke sini atau <span class="text-orange-600 underline">klik untuk pilih</span></p>
                        <p class="text-xs text-gray-400">PDF, DOCX, XLSX &bull; Maksimal 10MB</p>
                    </div>

                    <!-- Drag-over overlay -->
                    <div id="dropZoneDragging" class="hidden absolute inset-0 rounded-xl bg-orange-50 border-2 border-orange-400 flex flex-col items-center justify-center gap-2">
                        <svg class="w-10 h-10 text-orange-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                        <p class="text-sm font-semibold text-orange-600">Lepaskan untuk upload</p>
                    </div>
                </div>

                <!-- File Preview (setelah file dipilih) -->
                <div id="filePreview" class="hidden mt-3">
                    <div id="fileCard" class="flex items-center gap-4 p-4 rounded-xl border-2 transition-all duration-200">
                        <!-- Ikon tipe file -->
                        <div id="fileTypeIcon" class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 text-xs font-bold"></div>
                        <!-- Info file -->
                        <div class="flex-1 min-w-0">
                            <p id="fileName" class="text-sm font-semibold text-gray-800 truncate"></p>
                            <div class="flex items-center gap-2 mt-1">
                                <span id="fileSize" class="text-xs font-medium"></span>
                                <span class="text-gray-300">·</span>
                                <span id="fileSizeOf" class="text-xs text-gray-400">dari 10MB</span>
                            </div>
                            <!-- Progress bar -->
                            <div class="mt-2 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div id="fileSizeFill" class="h-full rounded-full transition-all duration-500 ease-out"></div>
                            </div>
                            <p id="errorBadType" class="text-xs text-red-500 mt-1 hidden font-medium">
                                &#9888; Format tidak didukung. Gunakan PDF, DOCX, atau XLSX.
                            </p>
                            <p id="errorTooBig" class="text-xs text-red-500 mt-1 hidden font-medium">
                                &#9888; Ukuran melebihi 10MB — kompres atau pilih file lain.
                            </p>
                        </div>
                        <!-- Tombol hapus -->
                        <button type="button" id="clearFile"
                                class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Jenis Kertas & Warna -->
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kertas <span class="text-red-500">*</span></label>
                    <div class="sel-wrap">
                        <select name="jenis_kertas" id="jenisKertas" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <?php
                            $kertas = array_unique(array_column($pricingList, 'jenis_kertas'));
                            foreach ($kertas as $k): ?>
                                <option value="<?= esc($k) ?>"><?= esc($k) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warna <span class="text-red-500">*</span></label>
                    <div class="sel-wrap">
                        <select name="warna_opsi" id="warnaOpsi" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="hitam_putih">Hitam Putih</option>
                            <option value="berwarna">Berwarna</option>
                        </select>
                        <div class="sel-arr"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Halaman & Copy -->
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Halaman <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_halaman" id="jumlahHal" value="1" min="1" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <p id="pageHintManual" class="text-xs text-gray-400 mt-1">Admin akan memverifikasi jumlah halaman sebelum mencetak.</p>
                    <p id="pageHintAuto" class="text-xs text-green-600 mt-1 hidden">&#10003; Terdeteksi otomatis dari dokumen. Bisa diubah jika perlu.</p>
                    <p id="pageHintLoading" class="text-xs text-orange-500 mt-1 hidden">Menghitung halaman&hellip;</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Copy <span class="text-red-500">*</span></label>
                    <input type="number" name="total_copy" id="totalCopy" value="1" min="1" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            <!-- Bolak-Balik -->
            <div class="mb-5">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <div class="relative mt-0.5">
                        <input type="checkbox" name="bolak_balik" id="bolakBalik" value="1"
                               class="sr-only peer">
                        <div class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:bg-orange-600 peer-checked:border-orange-600 transition-colors group-hover:border-orange-400"></div>
                        <svg class="absolute inset-0 w-5 h-5 text-white scale-75 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Print Bolak-Balik (Duplex)</span>
                        <p class="text-xs text-gray-400 mt-0.5">2 halaman per lembar — harga dihitung dari <strong class="text-gray-600">⌈halaman ÷ 2⌉</strong> lembar × tarif/lbr.</p>
                    </div>
                </label>
            </div>

            <!-- Catatan -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                <textarea name="catatan" rows="2" placeholder="e.g. staples, dll."
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
            </div>

            <!-- Estimasi Biaya -->
            <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Estimasi Biaya</p>
                        <p class="text-2xl font-bold text-orange-700" id="totalPrice">Rp 0</p>
                    </div>
                    <div class="text-right text-xs text-gray-400 space-y-0.5" id="priceBreakdown">
                        <p id="breakdownLine1"></p>
                        <p id="breakdownLine2" class="text-orange-500 font-medium hidden"></p>
                    </div>
                </div>
            </div>

            <button type="submit" id="submitBtn"
                    class="w-full bg-orange-600 text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Kirim Pesanan Print
            </button>
        </form>
    </div>

    <!-- Tabel Tarif -->
    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-700 mb-3">Tarif Print per Lembar</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-2 font-medium text-gray-600">Jenis Kertas</th>
                        <th class="text-right py-2 font-medium text-gray-600">Hitam Putih</th>
                        <th class="text-right py-2 font-medium text-gray-600">Berwarna</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pricing as $kertas => $warna): ?>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 text-gray-700"><?= esc($kertas) ?></td>
                            <td class="py-2 text-right text-gray-600">Rp <?= number_format($warna['hitam_putih'] ?? 0, 0, ',', '.') ?>/lbr</td>
                            <td class="py-2 text-right text-gray-600">Rp <?= number_format($warna['berwarna'] ?? 0, 0, ',', '.') ?>/lbr</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-gray-400 mt-3">* Semua harga per lembar. Bolak-balik: ⌈halaman ÷ 2⌉ lembar per copy.</p>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
const MAX_FILE_MB  = 10;
const MAX_FILE_B   = MAX_FILE_MB * 1024 * 1024;
const csrfName       = '<?= csrf_token() ?>';
const csrfToken      = document.querySelector('meta[name="csrf-token"]').content;
const calculateUrl   = '<?= base_url('/customer/print/calculate') ?>';
const countPagesUrl  = '<?= base_url('/customer/print/count-pages') ?>';

const elInput     = document.getElementById('dokumenInput');
const elDropZone  = document.getElementById('dropZone');
const elIdle      = document.getElementById('dropZoneIdle');
const elDragging  = document.getElementById('dropZoneDragging');
const elPreview   = document.getElementById('filePreview');
const elCard      = document.getElementById('fileCard');
const elTypeIcon  = document.getElementById('fileTypeIcon');
const elFileName  = document.getElementById('fileName');
const elFileSize  = document.getElementById('fileSize');
const elSizeFill  = document.getElementById('fileSizeFill');
const elFileError = document.getElementById('fileError');
const elClear     = document.getElementById('clearFile');
const elSubmit    = document.getElementById('submitBtn');

const ALLOWED_EXTS = ['pdf', 'docx', 'xlsx'];

const FILE_TYPES = {
    pdf:  { label: 'PDF',  bg: 'bg-red-100',   text: 'text-red-600'  },
    docx: { label: 'DOCX', bg: 'bg-blue-100',  text: 'text-blue-600' },
    xlsx: { label: 'XLSX', bg: 'bg-green-100', text: 'text-green-600'},
};

function getExt(name) {
    return name.split('.').pop().toLowerCase();
}

function showFile(file) {
    const ext      = getExt(file.name);
    const badType  = !ALLOWED_EXTS.includes(ext);
    const mb       = file.size / (1024 * 1024);
    const pct      = Math.min((file.size / MAX_FILE_B) * 100, 100);
    const tooBig   = file.size > MAX_FILE_B;
    const hasError = badType || tooBig;
    const type     = FILE_TYPES[ext] || { label: ext.toUpperCase() || '?', bg: 'bg-gray-100', text: 'text-gray-600' };

    elDropZone.classList.add('hidden');
    elPreview.classList.remove('hidden');

    elTypeIcon.className    = `w-12 h-12 rounded-xl flex items-center justify-center shrink-0 text-xs font-bold ${type.bg} ${type.text}`;
    elTypeIcon.textContent  = type.label;
    elFileName.textContent  = file.name;
    elFileSize.textContent  = mb.toFixed(2) + ' MB';
    elFileSize.className    = 'text-xs font-medium ' + (tooBig ? 'text-red-500' : 'text-green-600');

    elSizeFill.style.width = pct + '%';
    elSizeFill.className   = 'h-full rounded-full transition-all duration-500 ease-out ' + (hasError ? 'bg-red-400' : 'bg-orange-400');

    const msgBadType = document.getElementById('errorBadType');
    const msgTooBig  = document.getElementById('errorTooBig');
    msgBadType.classList.toggle('hidden', !badType);
    msgTooBig.classList.toggle('hidden', !tooBig);

    elCard.className = hasError
        ? 'flex items-center gap-4 p-4 rounded-xl border-2 border-red-200 bg-red-50 transition-all duration-200'
        : 'flex items-center gap-4 p-4 rounded-xl border-2 border-green-200 bg-green-50 transition-all duration-200';

    elSubmit.disabled = hasError;
}

function setPageHint(mode) {
    document.getElementById('pageHintManual').classList.toggle('hidden', mode !== 'manual');
    document.getElementById('pageHintAuto').classList.toggle('hidden', mode !== 'auto');
    document.getElementById('pageHintLoading').classList.toggle('hidden', mode !== 'loading');
}

async function detectPages(file) {
    setPageHint('loading');
    const ext = getExt(file.name);
    let pages = null;

    try {
        if (ext === 'pdf') {
            const ab  = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({ data: ab }).promise;
            pages = pdf.numPages;
        } else if (ext === 'docx') {
            const fd = new FormData();
            fd.append('dokumen', file);
            fd.append(csrfName, csrfToken);
            const r = await fetch(countPagesUrl, { method: 'POST', body: fd });
            const d = await r.json();
            if (d.pages) pages = d.pages;
        }
    } catch (e) {}

    if (pages && pages > 0) {
        document.getElementById('jumlahHal').value = pages;
        setPageHint('auto');
        calculate();
    } else {
        setPageHint('manual');
    }
}

function clearFile() {
    elInput.value = '';
    elPreview.classList.add('hidden');
    elDropZone.classList.remove('hidden');
    elSubmit.disabled = false;
    document.getElementById('jumlahHal').value = 1;
    setPageHint('manual');
    calculate();
}

function handleFile(file) {
    if (!file) return;
    const dt = new DataTransfer();
    dt.items.add(file);
    elInput.files = dt.files;
    showFile(file);
    detectPages(file);
}

elDropZone.addEventListener('click', () => elInput.click());

elDropZone.addEventListener('dragenter', e => {
    e.preventDefault();
    elDragging.classList.remove('hidden');
});
elDropZone.addEventListener('dragleave', e => {
    if (!elDropZone.contains(e.relatedTarget)) {
        elDragging.classList.add('hidden');
    }
});
elDropZone.addEventListener('dragover', e => e.preventDefault());
elDropZone.addEventListener('drop', e => {
    e.preventDefault();
    elDragging.classList.add('hidden');
    handleFile(e.dataTransfer.files[0]);
});

elInput.addEventListener('change', function () {
    if (this.files[0]) handleFile(this.files[0]);
});

elClear.addEventListener('click', clearFile);

function calculate() {
    const jenis   = document.getElementById('jenisKertas').value;
    const warna   = document.getElementById('warnaOpsi').value;
    const hal     = parseInt(document.getElementById('jumlahHal').value) || 1;
    const copy    = parseInt(document.getElementById('totalCopy').value) || 1;
    const duplex  = document.getElementById('bolakBalik').checked ? '1' : '0';

    const body = new URLSearchParams({
        jenis_kertas: jenis,
        warna_opsi: warna,
        jumlah_halaman: hal,
        total_copy: copy,
        bolak_balik: duplex,
        [csrfName]: csrfToken,
    });

    fetch(calculateUrl, { method: 'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body })
        .then(r => r.json())
        .then(d => {
            document.getElementById('totalPrice').textContent = d.total_formatted;

            const line1 = document.getElementById('breakdownLine1');
            const line2 = document.getElementById('breakdownLine2');

            if (duplex === '1') {
                line1.textContent = `${hal} hlm ÷ 2 = ${d.efektif_halaman} lbr × Rp ${d.tarif.toLocaleString('id-ID')}/lbr × ${copy} copy`;
                line2.textContent = 'Bolak-balik aktif ✓';
                line2.classList.remove('hidden');
            } else {
                line1.textContent = `${hal} lbr × Rp ${d.tarif.toLocaleString('id-ID')}/lbr × ${copy} copy`;
                line2.classList.add('hidden');
            }
        });
}

['jenisKertas','warnaOpsi','jumlahHal','totalCopy'].forEach(id => {
    document.getElementById(id).addEventListener('input', calculate);
});
document.getElementById('bolakBalik').addEventListener('change', calculate);

calculate();
</script>
<?= $this->endSection() ?>

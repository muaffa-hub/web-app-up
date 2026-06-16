<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?= esc($order['invoice_code']) ?> - Fikri Production</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
        }
    </style>
</head>
<body class="bg-gray-50">
<div class="max-w-2xl mx-auto my-8 bg-white rounded-xl border border-gray-200 p-8">
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-2xl font-bold"><span class="text-orange-600">Fikri</span><span class="text-gray-900"> Production</span></h1>
            <p class="text-gray-500 text-sm mt-1">Invoice</p>
        </div>
        <div class="text-right">
            <p class="font-mono font-bold text-gray-800 text-lg"><?= esc($order['invoice_code']) ?></p>
            <p class="text-gray-500 text-sm"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-8 text-sm">
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Customer</p>
            <p class="font-medium text-gray-800"><?= esc($order['nama_customer']) ?></p>
            <p class="text-gray-500"><?= esc($order['email_customer']) ?></p>
        </div>
        <div>
            <p class="text-gray-400 text-xs uppercase tracking-wide mb-1">Status</p>
            <p class="font-semibold text-gray-800"><?= esc(ucfirst($order['status_pesanan'])) ?></p>
            <p class="text-gray-500">Tipe: <?= esc(ucfirst($order['tipe_pesanan'])) ?></p>
        </div>
    </div>

    <?php if ($order['tipe_pesanan'] === 'produk' && !empty($order['items'])): ?>
        <table class="w-full text-sm mb-6">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-2 text-gray-600">Produk</th>
                    <th class="text-center py-2 text-gray-600">Qty</th>
                    <th class="text-right py-2 text-gray-600">Harga</th>
                    <th class="text-right py-2 text-gray-600">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr class="border-b border-gray-100">
                        <td class="py-2"><?= esc($item['nama_produk']) ?></td>
                        <td class="py-2 text-center"><?= esc($item['qty']) ?></td>
                        <td class="py-2 text-right">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="py-2 text-right font-medium">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($order['tipe_pesanan'] === 'print' && !empty($order['print_order'])): ?>
        <?php $po = $order['print_order']; ?>
        <div class="border rounded-lg p-4 mb-6 text-sm bg-gray-50">
            <p class="font-medium text-gray-700 mb-2">Detail Jasa Print</p>
            <div class="grid grid-cols-2 gap-2 text-gray-600">
                <span>Jenis Kertas:</span><span><?= esc($po['jenis_kertas']) ?></span>
                <span>Warna:</span><span><?= esc($po['warna_opsi'] === 'berwarna' ? 'Berwarna' : 'Hitam Putih') ?></span>
                <span>Halaman:</span><span><?= esc($po['jumlah_halaman_terverifikasi'] ?? $po['jumlah_halaman']) ?></span>
                <span>Copy:</span><span><?= esc($po['total_copy']) ?></span>
            </div>
        </div>
    <?php endif; ?>

    <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
        <?php if ($order['diskon_kupon'] > 0): ?>
            <div class="flex justify-between text-green-600">
                <span>Diskon Kupon</span>
                <span>-Rp <?= number_format($order['diskon_kupon'], 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>
        <div class="flex justify-between font-bold text-gray-800 text-base border-t border-gray-200 pt-2 mt-2">
            <span>TOTAL BAYAR</span>
            <span>Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-700">
        <strong>Cara Pembayaran:</strong> Bawa invoice ini ke ruang Unit Produksi dan bayar tunai sesuai nominal di atas.
    </div>

    <?php if ($order['catatan']): ?>
        <div class="mt-4 text-sm text-gray-500">
            <strong>Catatan:</strong> <?= esc($order['catatan']) ?>
        </div>
    <?php endif; ?>
</div>

<div class="text-center mt-4 no-print">
    <button onclick="window.print()" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700">Print Invoice</button>
    <a href="<?= base_url('/') ?>" class="ml-4 text-orange-600 hover:underline">Kembali ke Beranda</a>
    <a href="javascript:history.back()" class="ml-4 text-gray-500 hover:text-gray-700">Kembali</a>
</div>
</body>
</html>

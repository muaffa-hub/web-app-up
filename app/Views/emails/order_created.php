<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background: #f8f9fa; padding: 20px;">
<div style="max-width: 500px; margin: auto; background: white; border-radius: 12px; padding: 32px; border: 1px solid #e5e7eb;">
    <h2 style="color: #4f46e5; margin-top: 0;">Pesanan Berhasil Dibuat!</h2>
    <p>Halo <?= esc($order['nama_customer']) ?>,</p>
    <p>Pesanan kamu dengan invoice <strong><?= esc($order['invoice_code']) ?></strong> berhasil dibuat.</p>
    <p><strong>Total Bayar: Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?></strong></p>
    <p>Segera bayar ke ruang Unit Produksi dengan membawa invoice ini. Pesanan akan dibatalkan otomatis setelah 24 jam jika belum dibayar.</p>
    <div style="text-align: center; margin: 24px 0;">
        <a href="<?= esc($invoiceUrl) ?>" style="background: #4f46e5; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600;">Lihat Invoice</a>
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background: #f8f9fa; padding: 20px;">
<div style="max-width: 500px; margin: auto; background: white; border-radius: 12px; padding: 32px; border: 1px solid #e5e7eb;">
    <h2 style="color: #dc2626; margin-top: 0;">Pesanan Dibatalkan Otomatis</h2>
    <p>Halo <?= esc($order['nama_customer']) ?>,</p>
    <p>Pesanan kamu dengan invoice <strong><?= esc($order['invoice_code']) ?></strong> telah dibatalkan secara otomatis karena melewati batas waktu pembayaran (24 jam).</p>
    <p>Jika ingin memesan kembali, silakan buat pesanan baru melalui toko kami.</p>
</div>
</body>
</html>

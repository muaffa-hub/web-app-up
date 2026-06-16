<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background: #f8f9fa; padding: 20px;">
<div style="max-width: 500px; margin: auto; background: white; border-radius: 12px; padding: 32px; border: 1px solid #e5e7eb;">
    <h2 style="color: #4f46e5; margin-top: 0;">Penyesuaian Harga Pesanan Print</h2>
    <p>Halo,</p>
    <p>Ada penyesuaian harga pada pesanan <strong><?= esc($order['invoice_code']) ?></strong> berdasarkan verifikasi jumlah halaman file kamu.</p>
    <table style="width: 100%; margin: 16px 0; font-size: 14px;">
        <tr><td style="color: #6b7280;">Halaman awal:</td><td><strong><?= esc($printOrder['jumlah_halaman']) ?></strong></td></tr>
        <tr><td style="color: #6b7280;">Halaman terverifikasi:</td><td><strong><?= esc($verified) ?></strong></td></tr>
    </table>
    <p style="font-size: 18px;"><strong>Total Tagihan Terbaru: Rp <?= number_format($newTotal, 0, ',', '.') ?></strong></p>
    <p>Harap siapkan jumlah yang tepat saat datang ke ruang UP.</p>
</div>
</body>
</html>

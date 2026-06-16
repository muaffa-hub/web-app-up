<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background: #f8f9fa; padding: 20px;">
<div style="max-width: 500px; margin: auto; background: white; border-radius: 12px; padding: 32px; border: 1px solid #e5e7eb;">
    <h2 style="color: #4f46e5; margin-top: 0;">Update Status Pesanan</h2>
    <p>Status pesanan <strong><?= esc($order['invoice_code']) ?></strong> kamu diperbarui menjadi:</p>
    <p style="font-size: 20px; font-weight: bold; color: #4f46e5; text-align: center; margin: 20px 0;"><?= esc(ucfirst($newStatus)) ?></p>
    <p style="color: #6b7280; font-size: 13px;">Jika ada pertanyaan, hubungi ruang Unit Produksi.</p>
</div>
</body>
</html>

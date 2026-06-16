<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background: #f8f9fa; padding: 20px;">
<div style="max-width: 500px; margin: auto; background: white; border-radius: 12px; padding: 32px; border: 1px solid #e5e7eb;">
    <h2 style="color: #4f46e5; margin-top: 0;">Unit Produksi Sekolah</h2>
    <p>Halo,</p>
    <p>Terima kasih sudah mendaftar! Klik tombol di bawah untuk memverifikasi email kamu:</p>
    <div style="text-align: center; margin: 28px 0;">
        <a href="<?= esc($verifyUrl) ?>" style="background: #4f46e5; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600;">Verifikasi Email</a>
    </div>
    <p style="color: #6b7280; font-size: 13px;">Atau buka link ini: <a href="<?= esc($verifyUrl) ?>"><?= esc($verifyUrl) ?></a></p>
    <p style="color: #6b7280; font-size: 13px;">Jika kamu tidak mendaftar, abaikan email ini.</p>
</div>
</body>
</html>

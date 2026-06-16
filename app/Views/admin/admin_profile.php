<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
$words     = explode(' ', $user['nama'] ?? '');
$initials  = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));
$roleLabel = match($user['role'] ?? '') {
    'admin'   => 'Administrator',
    'petugas' => 'Petugas',
    default   => ucfirst($user['role'] ?? ''),
};
$since = !empty($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : '-';
?>

<div style="max-width:48rem" class="space-y-5">

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div style="height:4px;background:linear-gradient(90deg,#c2410c,#ea580c,#f97316)"></div>
        <div class="p-6" style="display:flex;align-items:center;gap:1.25rem">
            <div style="width:3.5rem;height:3.5rem;min-width:3.5rem;border-radius:1rem;background:linear-gradient(135deg,#c2410c,#f97316);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.25rem;font-weight:700;box-shadow:0 4px 12px rgba(234,88,12,.3)">
                <?= esc($initials ?: '?') ?>
            </div>
            <div style="flex:1;min-width:0">
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap">
                    <h1 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0;line-height:1.3"><?= esc($user['nama']) ?></h1>
                    <span style="font-size:.7rem;font-weight:600;background:#ffedd5;color:#c2410c;padding:2px 10px;border-radius:999px;white-space:nowrap"><?= esc($roleLabel) ?></span>
                </div>
                <div style="font-size:.875rem;color:#6b7280;margin-top:.35rem"><?= esc($user['email']) ?></div>
                <div style="font-size:.75rem;color:#9ca3af;margin-top:.15rem">Bergabung <?= esc($since) ?></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        <div class="bg-white rounded-2xl border border-gray-200 p-6" style="display:flex;flex-direction:column">
            <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem">
                <div style="width:2rem;height:2rem;min-width:2rem;border-radius:.625rem;background:#eff6ff;display:flex;align-items:center;justify-content:center">
                    <svg style="width:1rem;height:1rem;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div style="font-size:.875rem;font-weight:700;color:#1f2937">Ubah Email</div>
                    <div style="font-size:.75rem;color:#9ca3af">Perlu konfirmasi password</div>
                </div>
            </div>
            <form action="<?= base_url('/admin/profile/update-email') ?>" method="POST" style="display:flex;flex-direction:column;flex:1;gap:1rem">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Email Baru</label>
                    <input type="email" name="email" required value="<?= esc($user['email']) ?>"
                           class="w-full border border-gray-200 rounded-xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                           style="padding:.625rem .875rem">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Password Saat Ini</label>
                    <div class="relative">
                        <input type="password" name="password" id="ep-pass" required autocomplete="current-password"
                               placeholder="Masukkan password"
                               class="w-full border border-gray-200 rounded-xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                               style="padding:.625rem 2.5rem .625rem .875rem">
                        <button type="button" onclick="toggleVis('ep-pass',this)" tabindex="-1"
                                style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);color:#9ca3af;background:none;border:none;cursor:pointer;padding:0;display:flex">
                            <svg style="width:1rem;height:1rem" class="eye-off" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            <svg style="width:1rem;height:1rem;display:none" class="eye-on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>
                <div style="margin-top:auto;padding-top:.25rem">
                    <button type="submit" class="w-full bg-orange-600 text-white rounded-xl text-sm font-semibold hover:bg-orange-700 transition"
                            style="padding:.625rem 1rem">
                        Simpan Email
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6" style="display:flex;flex-direction:column">
            <div style="display:flex;align-items:center;gap:.625rem;margin-bottom:1.25rem">
                <div style="width:2rem;height:2rem;min-width:2rem;border-radius:.625rem;background:#fff7ed;display:flex;align-items:center;justify-content:center">
                    <svg style="width:1rem;height:1rem;color:#f97316" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <div style="font-size:.875rem;font-weight:700;color:#1f2937">Ubah Password</div>
                    <div style="font-size:.75rem;color:#9ca3af">Minimal 8 karakter</div>
                </div>
            </div>
            <form action="<?= base_url('/admin/profile/update-password') ?>" method="POST" style="display:flex;flex-direction:column;flex:1;gap:1rem">
                <?= csrf_field() ?>
                <?php
                $passFields = [
                    ['id' => 'pp-cur',  'name' => 'current_password', 'label' => 'Password Saat Ini', 'extra' => ''],
                    ['id' => 'pp-new',  'name' => 'new_password',     'label' => 'Password Baru',     'extra' => 'minlength="8"'],
                    ['id' => 'pp-conf', 'name' => 'confirm_password', 'label' => 'Konfirmasi Password Baru', 'extra' => 'oninput="checkMatch()"'],
                ];
                foreach ($passFields as $f): ?>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5"><?= esc($f['label']) ?></label>
                    <div class="relative">
                        <input type="password" name="<?= esc($f['name']) ?>" id="<?= esc($f['id']) ?>" required autocomplete="off"
                               <?= $f['extra'] ?>
                               class="w-full border border-gray-200 rounded-xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                               style="padding:.625rem 2.5rem .625rem .875rem">
                        <button type="button" onclick="toggleVis('<?= esc($f['id']) ?>',this)" tabindex="-1"
                                style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);color:#9ca3af;background:none;border:none;cursor:pointer;padding:0;display:flex">
                            <svg style="width:1rem;height:1rem" class="eye-off" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            <svg style="width:1rem;height:1rem;display:none" class="eye-on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    <?php if ($f['id'] === 'pp-conf'): ?>
                    <p id="match-msg" style="font-size:.75rem;margin-top:.375rem;display:none"></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <div style="margin-top:auto;padding-top:.25rem">
                    <button type="submit" class="w-full bg-orange-600 text-white rounded-xl text-sm font-semibold hover:bg-orange-700 transition"
                            style="padding:.625rem 1rem">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function toggleVis(id, btn) {
    var el     = document.getElementById(id);
    var hidden = el.type === 'password';
    el.type    = hidden ? 'text' : 'password';
    btn.querySelector('.eye-off').style.display = hidden ? 'none' : '';
    btn.querySelector('.eye-on').style.display  = hidden ? ''     : 'none';
}
function checkMatch() {
    var np  = document.getElementById('pp-new').value;
    var cf  = document.getElementById('pp-conf').value;
    var msg = document.getElementById('match-msg');
    if (!cf) { msg.style.display = 'none'; return; }
    msg.style.display = '';
    if (np === cf) {
        msg.textContent = '✓ Password cocok';
        msg.style.color = '#16a34a';
    } else {
        msg.textContent = '✗ Password tidak cocok';
        msg.style.color = '#ef4444';
    }
}
document.getElementById('pp-new').addEventListener('input', checkMatch);
</script>
<?= $this->endSection() ?>

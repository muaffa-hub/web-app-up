<?php
$notifCount = (new \App\Models\NotificationModel())->getUnreadCount(session()->get('user_id'));
$words      = explode(' ', session()->get('nama') ?? '');
$initials   = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));
?>
<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0">
    <h2 class="text-gray-700 font-semibold text-sm"><?= esc($pageTitle ?? 'Dashboard') ?></h2>

    <div class="flex items-center" style="gap:.75rem">

        <button onclick="toggleDark()" class="dm-toggle" title="Mode Gelap" role="switch" aria-label="Toggle dark mode">
            <span class="dm-knob">
                <svg id="dm-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 6.343l-.707-.707m12.728 12.728l-.707-.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <svg id="dm-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </span>
        </button>

        <a href="<?= base_url('/admin/notifications') ?>" style="position:relative;color:#6b7280;padding:4px;display:flex" class="hover:text-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <?php if ($notifCount > 0): ?>
            <span style="position:absolute;top:-2px;right:-2px;background:#ef4444;color:#fff;font-size:.65rem;border-radius:999px;width:1rem;height:1rem;display:flex;align-items:center;justify-content:center;font-weight:600"><?= esc($notifCount) ?></span>
            <?php endif; ?>
        </a>

        <div style="position:relative" id="ap-wrap">
            <button id="ap-btn" onclick="apToggle()"
                    class="flex items-center hover:bg-gray-100 rounded-lg transition"
                    style="gap:.5rem;padding:.375rem .625rem .375rem .25rem;cursor:pointer;border:none;background:none">
                <span style="width:1.75rem;height:1.75rem;min-width:1.75rem;border-radius:999px;background:#ea580c;color:#fff;font-size:.7rem;font-weight:700;display:flex;align-items:center;justify-content:center">
                    <?= esc($initials ?: '?') ?>
                </span>
                <span class="text-sm text-gray-700 font-medium" style="max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    <?= esc(session()->get('nama')) ?>
                </span>
                <svg id="ap-chev" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     style="width:.8rem;height:.8rem;min-width:.8rem;color:#9ca3af;transition:transform .2s ease">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="ap-drop" class="hidden bg-white rounded-xl border border-gray-100 overflow-hidden"
                 style="position:absolute;right:0;top:calc(100% + 6px);width:13rem;box-shadow:0 10px 25px rgba(0,0,0,.1);z-index:50">
                <div style="padding:.75rem 1rem;border-bottom:1px solid #f3f4f6;background:#f9fafb">
                    <div class="text-xs font-semibold text-gray-800 truncate"><?= esc(session()->get('nama')) ?></div>
                    <div class="text-xs text-gray-500 truncate"><?= esc(session()->get('email')) ?></div>
                </div>
                <div style="padding:.25rem 0">
                    <a href="<?= base_url('/admin/profile') ?>"
                       class="flex items-center text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700"
                       style="gap:.625rem;padding:.5rem 1rem">
                        <svg style="width:1rem;height:1rem;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Akun
                    </a>
                    <a href="<?= base_url('/') ?>"
                       class="flex items-center text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700"
                       style="gap:.625rem;padding:.5rem 1rem">
                        <svg style="width:1rem;height:1rem;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Toko
                    </a>
                </div>
                <div style="border-top:1px solid #f3f4f6;padding:.25rem 0">
                    <a href="<?= base_url('/logout') ?>"
                       class="flex items-center text-sm text-red-600 hover:bg-red-50"
                       style="gap:.625rem;padding:.5rem 1rem">
                        <svg style="width:1rem;height:1rem;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>

    </div>
</header>

<script>
function apToggle() {
    var drop = document.getElementById('ap-drop');
    var chev = document.getElementById('ap-chev');
    var open = !drop.classList.contains('hidden');
    drop.classList.toggle('hidden', open);
    chev.style.transform = open ? '' : 'rotate(180deg)';
}
document.addEventListener('click', function(e) {
    var wrap = document.getElementById('ap-wrap');
    if (wrap && !wrap.contains(e.target)) {
        document.getElementById('ap-drop').classList.add('hidden');
        document.getElementById('ap-chev').style.transform = '';
    }
});
</script>

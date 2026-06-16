<?php
$uri = service('uri');
$current = '/' . $uri->getPath();
$role = session()->get('role');

function isActive(string $path, string $current): string {
    return strpos($current, $path) === 0 ? 'bg-orange-700 text-white' : 'text-orange-100 hover:bg-orange-700';
}
?>
<aside class="w-64 bg-orange-800 flex-shrink-0 flex flex-col">
    <div class="h-16 flex items-center px-4 gap-3 flex-shrink-0">
        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo"
             class="h-8 w-8 object-contain">
        <div>
            <span class="font-bold text-base"><span class="text-orange-300">Fikri</span><span class="text-white"> Production</span></span>
            <?php if ($role === 'petugas'): ?>
            <div class="text-orange-300 text-xs font-medium">Petugas</div>
            <?php endif; ?>
        </div>
    </div>

    <nav class="adm-nav flex-1 px-3 py-4 space-y-1 overflow-y-auto">

        <?php if ($role === 'admin'): ?>
        <a href="<?= base_url('/admin/dashboard') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/dashboard', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <?php endif; ?>

        <a href="<?= base_url('/admin/orders') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/orders', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Pesanan
        </a>
        <a href="<?= base_url('/admin/print') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/print', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Pesanan Print
        </a>

        <?php if ($role === 'admin'): ?>
        <div class="pt-3 pb-1 px-3">
            <span class="text-orange-400 text-xs font-semibold uppercase tracking-wider">Kelola</span>
        </div>
        <a href="<?= base_url('/admin/products') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/products', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
            Produk
        </a>
        <a href="<?= base_url('/admin/categories') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/categories', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            Kategori
        </a>
        <a href="<?= base_url('/admin/coupons') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/coupons', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            Kupon
        </a>
        <a href="<?= base_url('/admin/print-pricing') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/print-pricing', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Tarif Print
        </a>
        <a href="<?= base_url('/admin/reports') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/reports', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Laporan
        </a>

        <div class="pt-3 pb-1 px-3">
            <span class="text-orange-400 text-xs font-semibold uppercase tracking-wider">Pengaturan</span>
        </div>
        <a href="<?= base_url('/admin/store-info') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/store-info', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Info Toko
        </a>
        <a href="<?= base_url('/admin/maintenance') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/maintenance', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Maintenance
        </a>
        <a href="<?= base_url('/admin/petugas') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= isActive('/admin/petugas', $current) ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Petugas
        </a>
        <?php endif; ?>

    </nav>

    <div class="flex-shrink-0 border-t border-orange-700 p-3">
        <a href="<?= base_url('/admin/profile') ?>"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition <?= isActive('/admin/profile', $current) ?>">
            <?php
            $words    = explode(' ', session()->get('nama') ?? '');
            $initials = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));
            ?>
            <span class="w-7 h-7 rounded-full bg-orange-500 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">
                <?= esc($initials ?: '?') ?>
            </span>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate"><?= esc(session()->get('nama')) ?></div>
                <div class="text-xs opacity-70 capitalize"><?= esc(session()->get('role')) ?></div>
            </div>
        </a>
        <a href="<?= base_url('/logout') ?>"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-orange-200 hover:bg-orange-700 hover:text-white transition mt-1">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
        </a>
    </div>
</aside>

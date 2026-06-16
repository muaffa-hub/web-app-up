<?php
$userId    = session()->get('user_id');
$cartCount = 0;
$notifCount = 0;
if ($userId) {
    $cartCount  = (new \App\Models\CartModel())->countItems($userId);
    $notifCount = (new \App\Models\NotificationModel())->getUnreadCount($userId);
}
?>
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <a href="<?= base_url('/') ?>" class="flex items-center gap-2.5 flex-shrink-0">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Fikri Production"
                     class="h-9 w-9 object-contain">
                <span class="text-lg font-bold leading-tight"><span class="text-orange-600">Fikri</span><span class="text-gray-900"> Production</span></span>
            </a>

            <div class="hidden md:flex flex-1 mx-8">
                <form action="<?= base_url('/catalog') ?>" method="GET" class="w-full max-w-lg flex">
                    <input type="text" name="q" value="<?= esc(service('request')->getGet('q') ?? '') ?>"
                           placeholder="Cari produk..."
                           class="w-full border border-gray-300 rounded-l-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-r-lg hover:bg-orange-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-2 md:gap-4">
                <button onclick="toggleDark()" class="dm-toggle" title="Mode Gelap" role="switch" aria-label="Toggle dark mode">
                    <span class="dm-knob">
                        <svg id="dm-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 6.343l-.707-.707m12.728 12.728l-.707-.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg id="dm-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </span>
                </button>

                <a href="<?= base_url('/customer/print') ?>" class="text-sm text-gray-600 hover:text-orange-600 hidden md:block">Jasa Print</a>
                <a href="<?= base_url('/info') ?>" class="text-sm text-gray-600 hover:text-orange-600 hidden md:block">Info</a>

                <?php if ($userId): ?>
                    <a href="<?= base_url('/customer/cart') ?>" class="relative text-gray-600 hover:text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-10H5.4m0 0L7 13m0 0l-2 9m2-9h10m0 0l2 9"/></svg>
                        <?php if ($cartCount > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"><?= esc($cartCount) ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?= base_url('/customer/notifications') ?>" class="relative text-gray-600 hover:text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <?php if ($notifCount > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"><?= esc($notifCount) ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="hs-dropdown relative hidden md:block">
                        <button class="flex items-center gap-2 text-sm text-gray-700 hover:text-orange-600">
                            <span><?= esc(session()->get('nama')) ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="hs-dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                            <a href="<?= base_url('/customer/orders') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Pesanan Saya</a>
                            <a href="<?= base_url('/customer/wishlist') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Wishlist</a>
                            <a href="<?= base_url('/customer/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <a href="<?= base_url('/admin/dashboard') ?>" class="block px-4 py-2 text-sm text-orange-600 hover:bg-gray-50">Admin Panel</a>
                            <?php endif; ?>
                            <hr class="my-1">
                            <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('/login') ?>" class="text-sm text-gray-600 hover:text-orange-600 hidden md:block">Login</a>
                    <a href="<?= base_url('/register') ?>" class="bg-orange-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-orange-700 hidden md:block">Daftar</a>
                <?php endif; ?>

                <button onclick="toggleMobileNav()" id="mob-btn" aria-label="Menu" class="md:hidden flex flex-col justify-center gap-1.5 w-8 h-8 text-gray-600 hover:text-orange-600">
                    <span id="mob-b1" class="block w-5 h-0.5 bg-current transition-all duration-200 origin-center"></span>
                    <span id="mob-b2" class="block w-5 h-0.5 bg-current transition-all duration-200"></span>
                    <span id="mob-b3" class="block w-5 h-0.5 bg-current transition-all duration-200 origin-center"></span>
                </button>
            </div>
        </div>

        <div id="mob-nav" class="hidden md:hidden pb-4 pt-1">
            <form action="<?= base_url('/catalog') ?>" method="GET" class="flex mb-3">
                <input type="text" name="q" value="<?= esc(service('request')->getGet('q') ?? '') ?>"
                       placeholder="Cari produk..."
                       class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                <button type="submit" class="bg-orange-600 text-white px-4 rounded-r-lg hover:bg-orange-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
            <div class="flex flex-col divide-y divide-gray-100 border border-gray-100 rounded-xl overflow-hidden">
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
                <a href="<?= base_url('/catalog') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    Katalog Produk
                </a>
                <a href="<?= base_url('/customer/print') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Jasa Print
                </a>
                <a href="<?= base_url('/info') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Info Toko
                </a>
                <?php if ($userId): ?>
                <a href="<?= base_url('/customer/orders') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Pesanan Saya
                </a>
                <a href="<?= base_url('/customer/wishlist') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Wishlist
                </a>
                <a href="<?= base_url('/customer/profile') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil
                </a>
                <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('/admin/dashboard') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-orange-600 hover:bg-orange-50">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    Admin Panel
                </a>
                <?php endif; ?>
                <a href="<?= base_url('/logout') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </a>
                <?php else: ?>
                <a href="<?= base_url('/login') ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </a>
                <a href="<?= base_url('/register') ?>" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-orange-600 hover:bg-orange-50">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Daftar Sekarang
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<script>
(function(){
    var open = false;
    window.toggleMobileNav = function(){
        open = !open;
        document.getElementById('mob-nav').classList.toggle('hidden', !open);
        var b1 = document.getElementById('mob-b1');
        var b2 = document.getElementById('mob-b2');
        var b3 = document.getElementById('mob-b3');
        b1.style.transform = open ? 'translateY(8px) rotate(45deg)' : '';
        b2.style.opacity   = open ? '0' : '';
        b3.style.transform = open ? 'translateY(-8px) rotate(-45deg)' : '';
    };
})();
</script>

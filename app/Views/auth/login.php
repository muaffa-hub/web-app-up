<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>
<a href="<?= base_url('/') ?>" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-orange-600 mb-4 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    Kembali ke Beranda
</a>
<div class="bg-white rounded-2xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Masuk</h2>
    <p class="text-gray-500 text-sm mb-6">Masuk ke akun kamu untuk mulai belanja.</p>

    <form action="<?= base_url('/login') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="<?= esc(old('email')) ?>" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
        </div>
        <div class="flex items-center justify-between mb-6">
            <a href="<?= base_url('/forgot-password') ?>" class="text-sm text-orange-600 hover:underline">Lupa password?</a>
        </div>
        <button type="submit" class="w-full bg-orange-600 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-700 transition">Masuk</button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Belum punya akun? <a href="<?= base_url('/register') ?>" class="text-orange-600 hover:underline font-medium">Daftar sekarang</a>
    </p>
</div>
<?= $this->endSection() ?>

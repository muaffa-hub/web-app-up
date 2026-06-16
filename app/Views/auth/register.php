<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-2xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Daftar Akun</h2>
    <p class="text-gray-500 text-sm mb-6">Buat akun untuk mulai berbelanja di Fikri Production.</p>

    <form action="<?= base_url('/register') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama" value="<?= esc(old('nama')) ?>" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="<?= esc(old('email')) ?>" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-gray-400">(min. 8 karakter)</span></label>
            <input type="password" name="password" required minlength="8"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirm" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <button type="submit" class="w-full bg-orange-600 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-700 transition">Daftar</button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Sudah punya akun? <a href="<?= base_url('/login') ?>" class="text-orange-600 hover:underline font-medium">Masuk</a>
    </p>
</div>
<?= $this->endSection() ?>

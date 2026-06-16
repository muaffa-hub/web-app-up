<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-2xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Lupa Password</h2>
    <p class="text-gray-500 text-sm mb-6">Masukkan email kamu dan kami akan mengirimkan link untuk reset password.</p>
    <form action="<?= base_url('/forgot-password') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <button type="submit" class="w-full bg-orange-600 text-white py-2.5 rounded-lg font-semibold hover:bg-orange-700">Kirim Link Reset</button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-4">
        <a href="<?= base_url('/login') ?>" class="text-orange-600 hover:underline">Kembali ke Login</a>
    </p>
</div>
<?= $this->endSection() ?>

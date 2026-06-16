<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="text-xl font-bold text-gray-800 mb-6">Notifikasi</h1>
<?php if (empty($notifications)): ?>
    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
        <p class="text-gray-400">Tidak ada notifikasi.</p>
    </div>
<?php else: ?>
    <div class="space-y-2 max-w-2xl">
        <?php foreach ($notifications as $n): ?>
            <div class="bg-white rounded-xl border border-gray-200 p-4 text-sm">
                <p class="text-gray-700"><?= esc($n['pesan']) ?></p>
                <p class="text-xs text-gray-400 mt-1"><?= date('d M Y H:i', strtotime($n['created_at'])) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\PrintOrderModel;

class CleanPrintFiles extends BaseCommand
{
    protected $group       = 'UP';
    protected $name        = 'clean:print-files';
    protected $description = 'Hapus file print dari pesanan selesai yang sudah lebih dari 72 jam.';

    public function run(array $params): void
    {
        $printOrderModel = new PrintOrderModel();
        $rows            = $printOrderModel->getFinishedForCleanup();

        if (empty($rows)) {
            CLI::write('Tidak ada file yang perlu dihapus.', 'green');
            return;
        }

        $deleted = 0;
        foreach ($rows as $row) {
            $filePath = WRITEPATH . 'uploads/documents/' . basename($row['file_path']);
            if (file_exists($filePath)) {
                if (@unlink($filePath)) {
                    log_message('info', 'CleanPrintFiles: berhasil hapus ' . $filePath);
                    $deleted++;
                } else {
                    log_message('error', 'CleanPrintFiles: gagal hapus ' . $filePath);
                }
            }
            $printOrderModel->update($row['id'], ['file_path' => null]);
        }

        CLI::write("Selesai. Total file dihapus: {$deleted}.", 'green');
    }
}

<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\PrintOrderModel;
use App\Libraries\GoogleDrive;

class CleanPrintFiles extends BaseCommand
{
    protected $group       = 'UP';
    protected $name        = 'clean:print-files';
    protected $description = 'Backup file print (pesanan selesai > 72 jam) ke Google Drive lalu hapus dari server.';

    public function run(array $params): void
    {
        $printOrderModel = new PrintOrderModel();
        $drive           = new GoogleDrive();

        if (!$drive->isConnected()) {
            CLI::error('Google Drive belum terhubung. Hubungkan dulu di Admin > Info Toko agar file dibackup sebelum dihapus.');
            return;
        }

        $rows = $printOrderModel->getFinishedForBackup();

        if (empty($rows)) {
            CLI::write('Tidak ada file yang perlu dibackup.', 'green');
            return;
        }

        $backed  = 0;
        $deleted = 0;
        foreach ($rows as $row) {
            $name     = basename($row['file_path']);
            $filePath = WRITEPATH . 'uploads/documents/' . $name;

            if (!file_exists($filePath)) {
                $printOrderModel->update($row['id'], ['file_path' => null]);
                continue;
            }

            $driveName = ($row['invoice_code'] ?? ('order-' . $row['order_id'])) . '__' . $name;
            $result    = $drive->uploadFile($filePath, $driveName);

            if (!$result) {
                CLI::error('Gagal backup: ' . $name . ' (file dipertahankan, akan dicoba lagi).');
                continue;
            }

            $printOrderModel->update($row['id'], [
                'drive_file_id' => $result['id'],
                'drive_url'     => $result['url'],
                'backed_up_at'  => date('Y-m-d H:i:s'),
            ]);
            $backed++;
            log_message('info', 'CleanPrintFiles: backup ke Drive ' . $name . ' -> ' . $result['id']);

            if (@unlink($filePath)) {
                $printOrderModel->update($row['id'], ['file_path' => null]);
                $deleted++;
                log_message('info', 'CleanPrintFiles: hapus lokal ' . $filePath);
            } else {
                log_message('error', 'CleanPrintFiles: gagal hapus lokal ' . $filePath);
            }
        }

        CLI::write("Selesai. Dibackup: {$backed}, dihapus dari server: {$deleted}.", 'green');
    }
}

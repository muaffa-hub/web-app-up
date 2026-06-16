<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = [
        'nama', 'email', 'password', 'google_id', 'role',
        'no_whatsapp',
    ];

    protected $validationRules = [
        'nama'  => 'required|max_length[100]',
        'email' => 'required|valid_email|max_length[150]',
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->where('deleted_at IS NULL')->first();
    }

    public function findByGoogleId(string $googleId): ?array
    {
        return $this->where('google_id', $googleId)->where('deleted_at IS NULL')->first();
    }

    public function getAdmins(): array
    {
        return $this->where('role', 'admin')->where('deleted_at IS NULL')->findAll();
    }
}

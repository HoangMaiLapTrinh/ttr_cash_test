<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailHistoryModel extends Model
{
    protected $table = 'email_histories';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code',
        'recipient',
        'cc',
        'bcc',
        'subject',
        'body',
        'error_message',
        'status',
        'sent_at',
        'resent_times',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}

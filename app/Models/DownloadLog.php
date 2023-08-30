<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    use HasFactory;
    protected $table = 'download_logs';

    protected $fillable = [
        'file_id',
        'downloaded_at',
        'ip_address',
        'user_agent',
        'country',
    ];
}

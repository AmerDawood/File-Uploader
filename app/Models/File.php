<?php

namespace App\Models;

use App\Models\Scopes\UserFileScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'size',
        'secret_key',
        'user_id',
    ];

    protected static function booted()
    {
       static::addGlobalScope(new UserFileScope);
    }

}

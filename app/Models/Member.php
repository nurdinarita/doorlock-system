<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'image',
        'card_uid',
    ];

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
}

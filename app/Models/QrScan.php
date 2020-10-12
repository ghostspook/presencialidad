<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'authorization_id',
    ];

    public function authorization() {
        return $this->belongsTo('App\Models\Authorization');
    }
}

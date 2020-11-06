<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'authorization_id',
        'authorized',
        'scanned_by',
        'location_id',
    ];

    public function authorization() {
        return $this->belongsTo('App\Models\Authorization');
    }

    public function location() {
        return $this->belongsTo('App\Models\Location');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationFile extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vaccination_id',
        'filename',
        'mime_type',
        'created_by',
        'path',
    ];

    function vaccination()
    {
        return $this->belongsTo('App\Models\Vaccination');
    }
}

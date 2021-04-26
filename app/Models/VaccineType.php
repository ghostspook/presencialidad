<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shots_required',
        'days_between_shots',
    ];
}

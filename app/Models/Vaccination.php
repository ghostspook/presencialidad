<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'vaccine_type_id',
        'vaccinated_date',
        'added_by',
        'comments'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'vaccinated_date' => 'datetime',
    ];

    public function vaccineType()
    {
        return $this->belongsTo('App\Models\VaccineType');
    }
}

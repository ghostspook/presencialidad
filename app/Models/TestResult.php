<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'test_date',
        'test_type',
        'result',
        'added_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'test_date' => 'datetime',
    ];

    function getTestTypeText()
    {
        switch ($this->test_type)
        {
            case 1:
                return 'Prueba rápida';
            case 2:
                return 'PCR';
            case 3:
                return 'Prueba cuantitativa';
            case 4:
                return 'Antígenos';
            default:
                return '?';
        }
    }

    function getResultText()
    {
        switch ($this->result)
        {
            case 1:
                return 'Negativo';
            case 2:
                return 'Positivo';
            default:
                return '?';
        }
    }

    function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    function file()
    {
        return $this->hasOne('\App\Models\TestResultFile');
    }

    function comments()
    {
        return $this->hasMany('\App\Models\TestResultComment');
    }
}

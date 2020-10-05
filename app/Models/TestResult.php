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
}

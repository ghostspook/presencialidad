<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'state',
        'actor',
    ];

    public function getStateText()
    {
        switch ($this->state)
        {
            case UserCard::PENDING_ENROLLMENT:
                return "Pendiente aceptación de términos";
            case UserCard::PENDING_QUESTIONNAIRE_1:
                return "Pendiente cuestionario 1";
            case UserCard::ADVICED_NOT_TO_ATTEND:
                return "Recomendación de no asistir";
            case UserCard::PENDING_COVERED_TEST_1:
                return "Pendiente prueba rápida 1";
            case UserCard::PENDING_COVERED_TEST_2:
                return "Pendiente prueba rápida 2";
            case UserCard::PENDING_PCR_TEST:
                return "Pendiente prueba PCR";
            case UserCard::PENDING_QUESTIONNAIRE_2:
                return "Pendiente cuestionario 2";
            case UserCard::PREEMPTIVE_QUARANTINE:
                return "Aislamiento preventivo";
            case UserCard::AUTHORIZED:
                return "Autorizado/a";
            default:
                return "?";
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function answer()
    {
        return $this->hasOne('App\Models\Answer');
    }
}

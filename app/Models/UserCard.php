<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    const PENDING_ENROLLMENT = 1;
    const PENDING_QUESTIONNAIRE_1 = 2;
    const PENDING_COVERED_TEST_1 = 3;
    const PENDING_COVERED_TEST_2 = 4;
    const PENDING_QUESTIONNAIRE_2 = 5;
    const AUTHORIZED = 6;
    const ADVICED_NOT_TO_ATTEND = 7;
    // const PENDING_ADVICE_OVERRIDE = 8;
    const PENDING_PCR_TEST = 9;
    const MANDATORY_QUARANTINE = 10;
    const PREEMPTIVE_QUARANTINE = 11;
    const PENDING_NON_COVERED_TEST = 12;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'days_authorazation_valid',
        'authorization_id',
        'mandatorily_quarantined_at',
        'preemptively_quarantined_at',
        'state',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'mandatorily_quarantined_at' => 'datetime',
        'preemptively_quarantined_at' => 'datetime',
        'most_recent_negative_test_result_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function authorization()
    {
        return $this->hasOne('App\Models\Authorization');
    }

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
            case UserCard::PENDING_PCR_TEST:
                return 'Pendiente prueba PCR';
            case UserCard::MANDATORY_QUARANTINE:
                return 'Cuarentena mandatoria';
            default:
                return "?";
        }
    }
}

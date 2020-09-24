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
    const AUTHORIZED = 5;
    const ADVICED_NOT_TO_ATTEND = 6;
    const PENDING_ADVICE_OVERRIDE = 7;
    const PENDING_PCR_TEST = 8;
    const MANDATORY_QUARANTINE = 9;
    const PREEMPTIVE_QUARANTINE = 10;
    const PENDING_NON_COVERED_TEST = 11;

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
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getStateText()
    {
        switch ($this->state)
        {
            case UserCard::PENDING_COVERED_TEST_1:
                return "Pendiente prueba rápida 1";
            case UserCard::PENDING_COVERED_TEST_2:
                return "Pendiente prueba rápida 2";
        }
    }
}

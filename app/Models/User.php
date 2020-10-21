<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'can_enter_test_results',
        'poses_risk_due_work_home_circumstance',
        'tracked_account_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userCard()
    {
        return $this->hasOne('App\Models\UserCard');
    }

    public function transitions()
    {
        return $this->hasMany('App\Models\Transition');
    }

    public function testResults() {
        return $this->hasMany('App\Models\TestResult');
    }

    public function trackedAccount() {
        return $this->belongsTo('App\Models\TrackedAccount');
    }
}

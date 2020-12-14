<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackedAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'account_type_id',
        'group_id',
    ];

    public function accountType()
    {
        return $this->belongsTo('App\Models\AccountType');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function getAccountTypeText()
    {
        return $this->accountType->name;
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }
}

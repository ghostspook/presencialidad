<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'default_required_initial_test_count',
        'automatically_require_maintenance_test',
    ];

    public function trackedAccounts()
    {
        return $this->hasMany('App\Models\TrackedAccount');
    }
}
